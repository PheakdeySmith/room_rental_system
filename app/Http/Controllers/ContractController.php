<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class ContractController extends Controller
{
    public function index()
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord')) {
            return redirect()->route('unauthorized');
        }

        $contracts = Contract::whereHas('room.property', function ($query) use ($currentUser) {
            $query->where('landlord_id', $currentUser->id);
        })
            ->with(['room.property', 'tenant'])
            ->latest()
            ->get();

        $availableRooms = Room::whereHas('property', function ($query) use ($currentUser) {
            $query->where('landlord_id', $currentUser->id);
        })
            ->where('status', Room::STATUS_AVAILABLE)
            ->with('property')
            ->get();

        $allRooms = Room::whereHas('property', function ($query) use ($currentUser) {
            $query->where('landlord_id', $currentUser->id);
        })
            ->with('property')
            ->get();

        $tenants = User::role('tenant')->where('landlord_id', $currentUser->id)->get();

        return view('backends.dashboard.contracts.index', compact(
            'contracts',
            'availableRooms',
            'allRooms',
            'tenants'
        ));
    }

    public function create()
    {
        $currentUser = Auth::user();
        // Get all rooms that belong to the landlord and are currently available
        $availableRooms = Room::whereHas('property', function ($query) use ($currentUser) {
            $query->where('landlord_id', $currentUser->id);
        })->where('status', 'available')->get();

        return view('backends.dashboard.contracts.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();

        // 1. Authorization Check: Ensure the current user is a landlord.
        if (!$currentUser->hasRole('landlord')) {
            return back()->with('error', 'Unauthorized action.');
        }

        // 2. Validation: Validate all incoming data, including a custom rule for the room.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'room_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($currentUser) {
                    $room = Room::with('property')->find($value);
                    if (!$room || $room->property->landlord_id !== $currentUser->id) {
                        $fail('The selected room is invalid or does not belong to you.');
                    } elseif ($room->status !== 'available') {
                        $fail('The selected room is not available.');
                    }
                },
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:daily,monthly,yearly',
            'contract_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $imageDbPath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_image_' . Str::slug($originalName) . '.' . $extension;
                $destinationPath = public_path('uploads/profile-photos');
                $relativeDbPath = 'uploads/profile-photos/' . $filename;

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }

                $file->move($destinationPath, $filename);
                $imageDbPath = $relativeDbPath;
            }

            $contractImageDbPath = null;
            if ($request->hasFile('contract_image')) {
                $file = $request->file('contract_image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_contract_' . Str::slug($originalName) . '.' . $extension;
                $destinationPath = public_path('uploads/contracts');
                $relativeDbPath = 'uploads/contracts/' . $filename;

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $file->move($destinationPath, $filename);
                $contractImageDbPath = $relativeDbPath;
            }

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
                'image' => $imageDbPath,
                'landlord_id' => $currentUser->id,
                'status' => 'active',
            ]);
            $user->assignRole('tenant');

            Contract::create([
                'user_id' => $user->id,
                'room_id' => $validatedData['room_id'],
                'landlord_id' => $currentUser->id,
                'start_date' => $validatedData['start_date'],
                'end_date' => $validatedData['end_date'],
                'rent_amount' => $validatedData['rent_amount'],
                'billing_cycle' => $validatedData['billing_cycle'],
                'status' => 'active',
                'contract_image' => $contractImageDbPath,
            ]);

            $room = Room::find($validatedData['room_id']);
            $room->status = 'occupied';
            $room->save();

            DB::commit();

            return redirect()->route('landlord.contracts.index')->with('success', 'New tenant and contract created successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create new tenant and contract: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.')->withInput();
        }
    }

    public function update(Request $request, Contract $contract)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $contract->room->property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        $validatedData = $request->validate([
             'user_id' => [
                'required',
                Rule::exists('users', 'id')->where(function ($query) use ($currentUser) {
                    return $query->where('landlord_id', $currentUser->id);
                }),
            ],
            'room_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($contract, $currentUser) {
                    $room = Room::with('property')->find($value);
                    if (!$room || !$room->property || $room->property->landlord_id !== $currentUser->id) {
                        $fail('The selected room does not belong to you.');
                        return;
                    }
                    if ($room->status !== Room::STATUS_AVAILABLE && $room->id !== $contract->room_id) {
                        $fail('The selected room is already occupied by another contract.');
                    }
                }
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:daily,monthly,yearly',
            'status' => 'required|string|in:active,expired,terminated',
            'contract_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        DB::beginTransaction();

        try {
            if ($request->hasFile('contract_image')) {
                if ($contract->contract_image && File::exists(public_path($contract->contract_image))) {
                    File::delete(public_path($contract->contract_image));
                }

                $file = $request->file('contract_image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_contract_' . Str::slug($originalName) . '.' . $extension;
                $destinationPath = public_path('uploads/contracts');
                $relativeDbPath = 'uploads/contracts/' . $filename;

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0755, true, true);
                }
                
                $file->move($destinationPath, $filename);

                $validatedData['contract_image'] = $relativeDbPath;
            }

            $originalRoomId = $contract->room_id;
            $newRoomId = (int)$validatedData['room_id'];

            $contract->update($validatedData);

            if ($originalRoomId !== $newRoomId) {
                $oldRoom = Room::find($originalRoomId);
                if ($oldRoom) {
                    $oldRoom->status = Room::STATUS_AVAILABLE;
                    $oldRoom->save();
                }
            }
            
            $newRoom = Room::find($newRoomId);
            if ($newRoom) {
                if ($contract->status === 'active') {
                    $newRoom->status = Room::STATUS_OCCUPIED;
                } else {
                    $newRoom->status = Room::STATUS_AVAILABLE;
                }
                $newRoom->save();
            }

            DB::commit();
            return back()->with('success', 'Contract and Room status updated successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Contract update failed for contract ID ' . $contract->id . ': ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Could not update the contract.')->withInput();
        }
    }

    public function destroy(Contract $contract)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $contract->room->property->landlord_id !== $currentUser->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();

        try {
            if ($contract->contract_image && File::exists(public_path($contract->contract_image))) {
                File::delete(public_path($contract->contract_image));
            }

            $room = $contract->room;
            if($room) {
                $room->status = Room::STATUS_AVAILABLE;
                $room->save();
            }
            
            $contract->delete();

            DB::commit();

            return redirect()->route('landlord.contracts.index')->with('success', 'Contract has been deleted successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Contract deletion failed for contract ID ' . $contract->id . ': ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to delete the contract.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord')) {
            return redirect()->route('unauthorized');
        }

        $validatedData = $request->validate([
            'user_id' => [
                'required',
                function ($attribute, $value, $fail) use ($currentUser) {
                    $tenant = User::find($value);
                    if (!$tenant || !$tenant->hasRole('tenant') || $tenant->landlord_id !== $currentUser->id) {
                        $fail('The selected tenant is invalid or does not belong to you.');
                    }
                },
            ],
            'room_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) use ($currentUser) {
                    $room = Room::with('property')->find($value);
                    if (!$room) {
                        $fail('The selected room does not exist.');
                        return;
                    }
                    if (!$room->property || $room->property->landlord_id !== $currentUser->id) {
                        $fail('The selected room does not belong to you.');
                        return;
                    }
                    if ($room->status !== Room::STATUS_AVAILABLE) {
                        $fail('The selected room is not available for a new contract.');
                        return;
                    }
                },
            ],
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|in:daily,monthly,yearly',
            'status' => 'required|string|in:active,expired,terminated',
            'contract_image' => 'nullable|image|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('contract_image')) {
                $validatedData['contract_image'] = $request->file('contract_image')->store('contracts', 'public');
            }

            Contract::create($validatedData);

            $room = Room::find($validatedData['room_id']);
            if ($room) {
                $room->status = Room::STATUS_OCCUPIED;
                $room->save();
            }

            DB::commit();

            return back()->with('success', 'Contract created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Contract creation failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Could not create the contract.')->withInput();
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
            // ... validation unchanged
            'required',
            function ($attribute, $value, $fail) use ($currentUser) {
                $tenant = User::find($value);
                if (!$tenant || !$tenant->hasRole('tenant') || $tenant->landlord_id !== $currentUser->id) {
                    $fail('The selected tenant is invalid or does not belong to you.');
                }
            },
        ],
        'room_id' => [
            // ... validation unchanged
            'required',
            'integer',
            function ($attribute, $value, $fail) use ($contract, $currentUser) {
                $room = Room::with('property')->find($value);
                if (!$room) {
                    $fail('The selected room does not exist.');
                    return;
                }
                if (!$room->property || $room->property->landlord_id !== $currentUser->id) {
                    $fail('The selected room does not belong to you.');
                    return;
                }
                $isTheOriginalRoom = ($room->id === $contract->room_id);
                $isAvailable = ($room->status === Room::STATUS_AVAILABLE);
                if (!$isAvailable && !$isTheOriginalRoom) {
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

    try {
        DB::beginTransaction();

        // Use getOriginal() to reliably get the values before the update
        $originalRoomId = $contract->getOriginal('room_id');
        $newRoomId = (int)$validatedData['room_id'];
        $newContractStatus = $validatedData['status'];

        if ($request->hasFile('contract_image')) {
            if ($contract->contract_image) {
                Storage::disk('public')->delete($contract->contract_image);
            }
            $validatedData['contract_image'] = $request->file('contract_image')->store('contracts', 'public');
        }

        // Update the contract itself
        $contract->update($validatedData);

        // --- NEW, ROBUST ROOM STATUS LOGIC ---

        // 1. If the room was changed, the original room is now free.
        if ($originalRoomId !== $newRoomId) {
            $oldRoom = Room::find($originalRoomId);
            if ($oldRoom) {
                $oldRoom->status = Room::STATUS_AVAILABLE;
                $oldRoom->save();
            }
        }

        // 2. Determine the correct final status for the contract's assigned room.
        $newRoom = Room::find($newRoomId);
        if ($newRoom) {
            if ($newContractStatus === 'active') {
                // If the contract is active, the room must be occupied.
                $newRoom->status = Room::STATUS_OCCUPIED;
            } else {
                // If the contract is expired or terminated, the room must be available.
                $newRoom->status = Room::STATUS_AVAILABLE;
            }
            $newRoom->save();
        }
        // --- END OF NEW LOGIC ---

        DB::commit();

        return back()->with('success', 'Contract and Room status updated successfully.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Contract update failed for contract ID ' . $contract->id . ': ' . $e->getMessage());
        return back()->with('error', 'An unexpected error occurred. Could not update the contract.')->withInput();
    }
}
}

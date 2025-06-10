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
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    // ... index() method is correct and remains the same ...
    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->hasRole('landlord')) {
            $contracts = Contract::whereHas('room.property', function ($query) use ($currentUser) {
                $query->where('landlord_id', $currentUser->id);
            })
                ->with(['room', 'tenant'])
                ->latest()
                ->get();

            $rooms = Room::whereHas('property', function ($query) use ($currentUser) {
                $query->where('landlord_id', $currentUser->id);
            })->get();

            $tenants = User::role('tenant')->where('landlord_id', $currentUser->id)->get();
        } else {
            return redirect()->route('unauthorized');
        }

        return view('backends.dashboard.contracts.index', compact('contracts', 'rooms', 'tenants'));
    }


    /**
     * Store a newly created contract in storage.
     */
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

            // --- REVISED AND CORRECTED VALIDATION FOR ROOM ID ---
            'room_id' => [
                'required',
                'integer',
                // This custom closure replaces the incorrect Rule::exists with whereHas.
                function ($attribute, $value, $fail) use ($currentUser) {
                    $room = Room::with('property')->find($value);

                    // 1. Check if the room exists.
                    if (!$room) {
                        $fail('The selected room does not exist.');
                        return;
                    }
                    // 2. Check if the room is available.
                    if ($room->status !== Room::STATUS_AVAILABLE) {
                        $fail('The selected room is not available.');
                        return;
                    }
                    // 3. Check if the room belongs to the landlord.
                    if (!$room->property || $room->property->landlord_id !== $currentUser->id) {
                        $fail('The selected room does not belong to you.');
                    }
                },
            ],
            // --- The rest of the validation remains correct ---
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
}
<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $roomTypesQuery = RoomType::query();

        if ($currentUser->hasRole('landlord')) {
            $roomTypes = $roomTypesQuery
                ->where('landlord_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            return abort(403, 'Unauthorized action: You do not have permission to view this list.');
        }

        return view('backends.dashboard.room_types.index', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord')) {
            return back()->with('error', 'You are not authorized to create room type.')->withInput();
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity'=> 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            RoomType::create([
                'landlord_id' => $currentUser->id,
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'capacity' => $validatedData['capacity'],
            ]);

            DB::commit();

            return back()->with('success', 'Room Type created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Log the error for debugging.
            Log::error('Room Type creation failed: ' . $e->getMessage());

            // Redirect back with a user-friendly error message.
            return back()->with('error', 'An unexpected error occurred. Could not create the room type.')->withInput();
        }
    }

    public function update(Request $request, RoomType $roomType)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $roomType->landlord_id !== $currentUser->id) {
            return back()->with('error', 'You are not authorized to update this room type.')->withInput();
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'capacity'=> 'required|integer|min:1',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            $roomType->update($validatedData);

            DB::commit();

            return back()->with('success', 'Room Type updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Room Type update failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred during room type update.')->withInput();
        }
    }

    public function destroy(Request $request, RoomType $roomType)
    {
        $currentUser = Auth::user();

        $canDelete = false;

        if ($currentUser->hasRole('landlord')) {
            if ($roomType->landlord_id === $currentUser->id) {
                $canDelete = true;
            }
        }

        if (!$canDelete) {
            return back()->with('error', 'Unauthorized action to delete this room type.');
        }

        $roomType->delete();

        return back()->with('success', value: 'Room Type deleted successfully.');
    }
    
}

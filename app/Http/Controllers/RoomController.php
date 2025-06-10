<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Property;
use App\Models\RoomType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class RoomController extends Controller
{

    public function index()
    {
        $currentUser = Auth::user();

        if ($currentUser->hasRole('landlord')) {
            $rooms = Room::whereHas('property', function ($query) use ($currentUser) {
                $query->where('landlord_id', $currentUser->id);
            })
                ->with('property', 'roomType')
                ->latest()
                ->get();

            $properties = Property::where('landlord_id', $currentUser->id)->get();

            $roomTypes = RoomType::where('landlord_id', $currentUser->id)->get();

        } else {
            return redirect()->route('unauthorized');
        }

        return view('backends.dashboard.rooms.index', compact('rooms', 'properties', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord')) {
            return redirect()->route('unauthorized');
        }

        $validatedData = $request->validate([

            'property_id' => [
                'required',
                Rule::exists('properties', 'id')->where(function ($query) use ($currentUser) {
                    $query->where('landlord_id', $currentUser->id);
                }),
            ],
            'room_type_id' => [
                'required',
                Rule::exists('room_types', 'id')->where(function ($query) use ($currentUser) {
                    $query->where('landlord_id', $currentUser->id);
                }),
            ],
            'room_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('rooms')->where(function ($query) use ($request) {
                    return $query->where('property_id', $request->property_id);
                }),
            ],
            'description' => 'nullable|string',
            'size' => 'nullable|string|max:255',
            'floor' => 'nullable|integer',
            'status' => 'required|string|in:available,occupied,maintenance',
        ]);

        try {
            DB::beginTransaction();

            Room::create($validatedData);

            DB::commit();

            return back()->with('success', 'Room created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Room creation failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Could not create the room.')->withInput();
        }
    }

    public function update(Request $request, Room $room)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $room->property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        $validatedData = $request->validate([
            'property_id' => [
                'required',
                Rule::exists('properties', 'id')->where('landlord_id', $currentUser->id),
            ],
            'room_type_id' => [
                'required',
                Rule::exists('room_types', 'id')->where('landlord_id', $currentUser->id),
            ],
            'room_number' => [
                'required',
                'string',
                'max:255',

                Rule::unique('rooms')->ignore($room->id)->where(function ($query) use ($request) {
                    return $query->where('property_id', $request->property_id);
                }),
            ],
            'description' => 'nullable|string',
            'size' => 'nullable|string|max:255',
            'floor' => 'nullable|integer',
            'status' => 'required|string|in:available,occupied,maintenance',
        ]);

        try {
            DB::beginTransaction();

            $room->update($validatedData);

            DB::commit();

            return back()->with('success', 'Room updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Room update failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Could not update the room.');
        }
    }

    /**
     * Remove the specified room from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Room $room)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $room->property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        try {
            DB::beginTransaction();

            $room->delete();

            DB::commit();

            return back()->with('success', 'Room deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Room deletion failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Could not delete the room.');
        }
    }

}

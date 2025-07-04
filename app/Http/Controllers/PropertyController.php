<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\BasePrice;
use App\Models\UtilityType;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $propertiesQuery = Property::query();

        if ($currentUser->hasRole('landlord')) {
            $properties = $propertiesQuery
                ->with('roomTypes')
                ->where('landlord_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            return redirect()->route('unauthorized');
        }

        $utilityTypes = UtilityType::latest()->get();

        return view('backends.dashboard.properties.index', compact('properties', 'utilityTypes'));
    }

    public function show(Property $property)
    {
        $currentUser = Auth::user();
        if ($currentUser->id !== $property->landlord_id) {
            abort(403, 'Unauthorized Action');
        }

        $property->load(
            'contracts.tenant',
            'contracts.room',
            'roomTypes'
        );

        $rooms = Room::where('property_id', $property->id)
            ->with('roomType', 'amenities')
            ->latest()
            ->paginate(10);

        $basePrices = BasePrice::where('property_id', $property->id)
            ->get()
            ->keyBy('room_type_id');

        $amenities = Amenity::where('landlord_id', $currentUser->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $tenants = User::role('tenant')->where('landlord_id', $currentUser->id)->get();

        $allRooms = Room::whereHas('property', function ($query) use ($currentUser) {
            $query->where('landlord_id', $currentUser->id);
        })
            ->with('property')
            ->get();

        return view('backends.dashboard.properties.show', [
            'property' => $property,
            'rooms' => $rooms,
            'basePrices' => $basePrices,
            'roomTypes' => $property->roomTypes,
            'amenities' => $amenities,
            'tenants' => $tenants,
            'allRooms' => $allRooms,
        ]);
    }

    public function store(Request $request)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord')) {
            return redirect()->route('unauthorized');
        }

        // 1. ADDED: Proper validation rules for each property field.
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'property_type' => 'required|string|in:apartment,house,condo,townhouse,commercial', // Matches the form
            'description' => 'nullable|string',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state_province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB Max
            'status' => 'required|string|in:active,inactive',
        ]);

        // Wrap the entire operation in a database transaction for safety.
        try {
            DB::beginTransaction();

            $imageDbPath = null;

            // --- Image Upload Logic ---
            if ($request->hasFile('cover_image')) {
                $file = $request->file('cover_image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();

                // Create a clean, URL-friendly filename
                $filename = time() . '_' . Str::slug($originalName) . '.' . $extension;
                $destinationPath = public_path('uploads/property-photos');

                // Ensure the directory exists
                File::makeDirectory($destinationPath, 0755, true, true);

                // Move the file
                $file->move($destinationPath, $filename);

                // Set the path for the database
                $imageDbPath = 'uploads/property-photos/' . $filename;
            }

            // 2. FIXED: The main data mapping is now correct.
            // It uses the correct keys from $validatedData.
            Property::create([
                'landlord_id' => $currentUser->id,
                'name' => $validatedData['name'],
                'property_type' => $validatedData['property_type'],
                'description' => $validatedData['description'],
                'address_line_1' => $validatedData['address_line_1'],
                'address_line_2' => $validatedData['address_line_2'] ?? null,
                'city' => $validatedData['city'],
                'state_province' => $validatedData['state_province'],
                'postal_code' => $validatedData['postal_code'],
                'country' => $validatedData['country'],
                'year_built' => $validatedData['year_built'] ?? null,
                'status' => $validatedData['status'],
                'cover_image' => $imageDbPath, // Use the path from our logic
            ]);

            // If everything was successful, commit the transaction.
            DB::commit();

            return back()->with('success', 'Property created successfully.');

        } catch (\Exception $e) {
            // 3. ADDED: If any error occurs, rollback the transaction.
            DB::rollBack();

            // Log the error for debugging.
            Log::error('Property creation failed: ' . $e->getMessage());

            // Redirect back with a user-friendly error message.
            return back()->with('error', 'An unexpected error occurred. Could not create the property.')->withInput();
        }
    }

    public function createPrice(Property $property)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord') || $property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        $property->load('roomTypes');

        $allRoomTypes = RoomType::where('landlord_id', $currentUser->id)
            ->orderBy('name')
            ->get();

        // Pass both to the view
        return view('backends.dashboard.properties.create-price', compact('property', 'allRoomTypes'));
    }

    // In app/Http/Controllers/PropertyController.php

    public function storePrice(Request $request, Property $property)
    {
        // ... authorization and trim logic ...

        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',

            // --- CHANGE #1: Use the simpler 'date' rule ---
            'effective_date' => 'required|date',

            'room_type_id' => [
                'required',
                'exists:room_types,id',
                Rule::unique('base_prices')->where(function ($query) use ($property, $request) {
                    return $query->where('property_id', $property->id)
                        ->where('effective_date', Carbon::parse($request->effective_date)->toDateString());
                }),
            ],
        ], [
            'room_type_id.unique' => 'A price for this room type on this effective date has already been set.',

            'effective_date.date' => 'The effective date must be a valid date (e.g., 2025-06-13).',
        ]);

        try {
            $property->roomTypes()->attach($validatedData['room_type_id'], [
                'price' => $validatedData['price'],
                'effective_date' => $validatedData['effective_date'],
            ]);

            return back()->with('success', 'Room type price set successfully for this property.');

        } catch (\Exception $e) {
            Log::error('Failed to store price: ' . $e->getMessage());
            return back()->with('error', 'Could not store the price. Please try again.')->withInput();
        }
    }

    public function updatePrice(Request $request, Property $property)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord') || $property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        // We need the original effective date to find the record to update
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
            'effective_date' => 'required|date_format:Y-m-d',
            'room_type_id' => 'required|exists:room_types,id',
            'original_effective_date' => 'required|date_format:Y-m-d', // Hidden input from the form
        ]);

        // Find the pivot record using the original date and update it with the new data
        $property->roomTypes()
            ->where('room_type_id', $validatedData['room_type_id'])
            ->wherePivot('effective_date', $validatedData['original_effective_date'])
            ->updateExistingPivot($validatedData['room_type_id'], [
                'price' => $validatedData['price'],
                'effective_date' => Carbon::parse($validatedData['effective_date']),
            ]);

        return back()->with('success', 'Price updated successfully.');
    }

    public function destroyPrice(Request $request, Property $property)
    {
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord') || $property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        // Validate that we received the necessary data to identify the record
        $data = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'effective_date' => 'required|date_format:Y-m-d',
        ]);

        $property->roomTypes()
            ->wherePivot('effective_date', $data['effective_date'])
            ->detach($data['room_type_id']);

        return back()->with('success', 'Price assignment deleted successfully.');
    }

    public function update(Request $request, Property $property)
    {
        $currentUser = Auth::user();

        if (!$currentUser->hasRole('landlord') || $property->landlord_id !== $currentUser->id) {
            return redirect()->route('unauthorized');
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'property_type' => 'required|string|in:apartment,house,condo,townhouse,commercial',
            'description' => 'nullable|string',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state_province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'year_built' => 'nullable|integer|min:1800|max:' . date('Y'),
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();

            // Handle image update
            if ($request->hasFile('cover_image')) {
                // Delete old image
                if ($property->cover_image && File::exists(public_path($property->cover_image))) {
                    File::delete(public_path($property->cover_image));
                }

                $file = $request->file('cover_image');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . Str::slug($originalName) . '.' . $extension;
                $destinationPath = public_path('uploads/property-photos');

                File::makeDirectory($destinationPath, 0755, true, true);
                $file->move($destinationPath, $filename);
                $validatedData['cover_image'] = 'uploads/property-photos/' . $filename;
            }

            $property->update($validatedData);

            DB::commit();

            return back()->with('success', 'Property updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Property update failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred during property update.')->withInput();
        }
    }

    public function destroy(Request $request, Property $property)
    {
        $currentUser = Auth::user();

        $canDelete = false;

        if ($currentUser->hasRole('landlord')) {
            if ($property->landlord_id === $currentUser->id) {
                $canDelete = true;
            }
        }

        if (!$canDelete) {
            return redirect()->route('unauthorized');
        }

        if ($property->cover_image && File::exists(public_path($property->cover_image))) {
            File::delete(public_path($property->cover_image));
        }

        $property->delete();

        return back()->with('success', value: 'Property deleted successfully.');
    }
}

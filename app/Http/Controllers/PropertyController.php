<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
                ->where('landlord_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            return abort(403, 'Unauthorized action: You do not have permission to view this list.');
        }

        return view('backends.dashboard.properties.index', compact('properties'));
    }

    public function store(Request $request)
    {
        // Authorize first: Ensure the user is a logged-in landlord.
        $currentUser = Auth::user();
        if (!$currentUser || !$currentUser->hasRole('landlord')) {
            return back()->with('error', 'You are not authorized to create properties.')->withInput();
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

    public function update(Request $request, Property $property)
    {
        $currentUser = Auth::user();

        // Authorization check
        if (!$currentUser->hasRole('landlord') || $property->landlord_id !== $currentUser->id) {
            return back()->with('error', 'You are not authorized to update this property.')->withInput();
        }

        // Validation for property fields
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
            return back()->with('error', 'Unauthorized action to delete this property.');
        }

        if ($property->cover_image && File::exists(public_path($property->cover_image))) {
            File::delete(public_path($property->cover_image));
        }

        $property->delete();

        return back()->with('success', value: 'Property deleted successfully.');
    }
}

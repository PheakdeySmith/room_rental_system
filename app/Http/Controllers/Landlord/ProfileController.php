<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('backends.dashboard.landlord.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => $request->company,
        ];

        // Handle profile image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Create uploads directory if it doesn't exist
            $uploadsDir = public_path('uploads/users');
            if (!File::isDirectory($uploadsDir)) {
                File::makeDirectory($uploadsDir, 0755, true);
            }
            
            // Delete old image if it exists
            if ($user->image && File::exists(public_path('uploads/users/' . $user->image))) {
                File::delete(public_path('uploads/users/' . $user->image));
            }
            
            // Save new image
            $image->move($uploadsDir, $imageName);
            $data['image'] = $imageName;
        }

        $user->update($data);

        return redirect()->route('landlord.profile.index')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('landlord.profile.index')->with('success', 'Password updated successfully!');
    }

    public function updateQRCodes(Request $request)
    {
        $user = Auth::user();

        // Debug information
        \Log::info('QR Code Update Request', [
            'has_qr_code_1' => $request->hasFile('qr_code_1'),
            'has_qr_code_2' => $request->hasFile('qr_code_2'),
            'remove_qr_1' => $request->boolean('remove_qr_1'),
            'remove_qr_2' => $request->boolean('remove_qr_2'),
            'all_files' => $request->allFiles(),
            'all_inputs' => $request->all()
        ]);

        $request->validate([
            'qr_code_1' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'qr_code_2' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'remove_qr_1' => ['nullable', 'boolean'],
            'remove_qr_2' => ['nullable', 'boolean'],
        ]);

        $data = [];

        // Create QR codes directory if it doesn't exist
        $uploadsDir = public_path('uploads/qrcodes');
        if (!File::isDirectory($uploadsDir)) {
            File::makeDirectory($uploadsDir, 0755, true);
        }

        // Handle QR Code 1
        \Log::info('Processing QR Code 1', [
            'hasFile' => $request->hasFile('qr_code_1'),
            'file_exists' => isset($_FILES['qr_code_1']),
            'file_details' => $request->hasFile('qr_code_1') ? [
                'name' => $request->file('qr_code_1')->getClientOriginalName(),
                'size' => $request->file('qr_code_1')->getSize(),
                'mime' => $request->file('qr_code_1')->getMimeType(),
            ] : 'No file'
        ]);
        
        if ($request->hasFile('qr_code_1')) {
            $qrCode = $request->file('qr_code_1');
            // Generate a simpler, more reliable filename
            $qrCodeName = 'qr1_user_' . $user->id . '_' . time() . '.' . $qrCode->getClientOriginalExtension();
            
            // Delete old QR code if it exists
            if ($user->qr_code_1 && File::exists(public_path('uploads/qrcodes/' . $user->qr_code_1))) {
                File::delete(public_path('uploads/qrcodes/' . $user->qr_code_1));
            }
            
            // Ensure directory exists
            if (!File::isDirectory($uploadsDir)) {
                File::makeDirectory($uploadsDir, 0755, true, true);
            }
            
            try {
                // Save new QR code
                $qrCode->move($uploadsDir, $qrCodeName);
                
                \Log::info('QR Code 1 uploaded', [
                    'path' => $uploadsDir . '/' . $qrCodeName,
                    'exists' => File::exists($uploadsDir . '/' . $qrCodeName)
                ]);
                
                // Make sure the file exists after saving
                if (File::exists($uploadsDir . '/' . $qrCodeName)) {
                    $data['qr_code_1'] = $qrCodeName;
                } else {
                    \Log::error('QR Code 1 file not found after upload');
                    return redirect()->route('landlord.profile.index')
                        ->with('error', 'Failed to upload QR code 1. Please try again.');
                }
            } catch (\Exception $e) {
                \Log::error('QR Code 1 upload error', ['exception' => $e->getMessage()]);
                return redirect()->route('landlord.profile.index')
                    ->with('error', 'Error uploading QR code 1: ' . $e->getMessage());
            }
        } elseif ($request->boolean('remove_qr_1')) {
            // Remove QR code 1 if requested
            if ($user->qr_code_1 && File::exists(public_path('uploads/qrcodes/' . $user->qr_code_1))) {
                File::delete(public_path('uploads/qrcodes/' . $user->qr_code_1));
            }
            $data['qr_code_1'] = null;
        }

        // Handle QR Code 2
        if ($request->hasFile('qr_code_2')) {
            $qrCode = $request->file('qr_code_2');
            // Generate a simpler, more reliable filename
            $qrCodeName = 'qr2_user_' . $user->id . '_' . time() . '.' . $qrCode->getClientOriginalExtension();
            
            // Delete old QR code if it exists
            if ($user->qr_code_2 && File::exists(public_path('uploads/qrcodes/' . $user->qr_code_2))) {
                File::delete(public_path('uploads/qrcodes/' . $user->qr_code_2));
            }
            
            // Ensure directory exists
            if (!File::isDirectory($uploadsDir)) {
                File::makeDirectory($uploadsDir, 0755, true, true);
            }
            
            // Save new QR code
            $qrCode->move($uploadsDir, $qrCodeName);
            
            // Make sure the file exists after saving
            if (File::exists($uploadsDir . '/' . $qrCodeName)) {
                $data['qr_code_2'] = $qrCodeName;
            } else {
                return redirect()->route('landlord.profile.index')
                    ->with('error', 'Failed to upload QR code 2. Please try again.');
            }
        } elseif ($request->boolean('remove_qr_2')) {
            // Remove QR code 2 if requested
            if ($user->qr_code_2 && File::exists(public_path('uploads/qrcodes/' . $user->qr_code_2))) {
                File::delete(public_path('uploads/qrcodes/' . $user->qr_code_2));
            }
            $data['qr_code_2'] = null;
        }

        if (!empty($data)) {
            $user->update($data);
        }

        return redirect()->route('landlord.profile.index')->with('success', 'QR codes updated successfully!');
    }
}

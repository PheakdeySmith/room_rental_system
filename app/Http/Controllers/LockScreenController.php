<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LockScreenController extends Controller
{
    /**
     * Show the lock screen page.
     */
    public function show()
    {
        session(['locked' => true]);
        return view('backends.dashboard.auth.lockscreen');
    }

    /**
     * Handle the unlock attempt.
     */
    public function unlock(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Check if the provided password is correct for the logged-in user.
        if (!Hash::check($request->password, Auth::user()->password)) {
            // If incorrect, redirect back with an error.
            return back()->withErrors([
                'password' => 'The provided password does not match our records.',
            ]);
        }

        // If correct, clear the session variable and redirect to the dashboard.
        session()->forget('locked');

        return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // This guarantees a redirect to the login page.
        return redirect()->route('login');
    }
}
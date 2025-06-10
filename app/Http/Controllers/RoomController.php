<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{

    public function index()
    {
        $currentUser = Auth::user();
        $roomsQuery = Room::query();

        if ($currentUser->hasRole('landlord')) {
            $rooms = $roomsQuery
                ->where('landlord_id', $currentUser->id)
                ->latest()
                ->get();
        } else {
            return abort(403, 'Unauthorized action: You do not have permission to view this list.');
        }

        return view('backends.dashboard.rooms.index', compact('rooms'));
    }

}
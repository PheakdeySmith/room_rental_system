<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\RoomService;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RoomController extends Controller
{
    use AuthorizesRequests;

    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
        $this->middleware(['auth', 'role:landlord|admin']);
    }

    public function index()
    {
        // Admin sees all rooms, landlords see only their own
        $user = Auth::user();
        if($user && $user->hasRole('admin')) {
            $rooms = Room::with('landlord')->get();
        } else {
            $rooms = $this->roomService->getAll();
        }

        return view('backends.dashboard.rooms.index', compact('rooms'));
    }

    public function create()
    {
        // Landlords see only their own rooms, admin can see all rooms
        $user = Auth::user();
        if ($user && $user->hasRole('landlord')) {
            $rooms = $user->rooms()->get();
        } else {
            $rooms = Room::all();
        }

        return view('backends.dashboard.rooms.create', compact('rooms'));
    }

    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();

        $user = Auth::user();
        if($user && $user->hasRole('admin')) {
            $data['landlord_id'] = $request->input('landlord_id');
        } else {
            $data['landlord_id'] = $user->id;
        }

        // Create the contract using the service layer
        $this->contractService->create($data);

        return redirect()->route('rooms.index')->with('success', 'Contract created');
    }
}

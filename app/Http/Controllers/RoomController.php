<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Services\RoomService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        if ($user && $user->hasRole('admin')) {
            $rooms = Room::with('landlord')->get();
        } else {
            $rooms = $this->roomService->getAll();
        }

        return view('backends.dashboard.rooms.index', compact('rooms'));
    }

    public function store(StoreRoomRequest $request)
    {
        try {
            $data = $request->validated();

            $user = Auth::user();
            if ($user && $user->hasRole('admin')) {
                $data['landlord_id'] = $request->input('landlord_id');
            } else {
                $data['landlord_id'] = $user->id;
            }

            $this->roomService->create($data);

            return redirect()->route('rooms.index')->with('success', 'Room created successfully.');

        } catch (\Exception $e) {
            // Log the error
            \Log::error('Room store error: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Failed to create room.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $this->roomService->update($id, $request->all());

            return redirect()->back()->with('success', 'Room updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update room.');
        }
    }


    public function destroy(int $id)
    {
        try {
            $this->roomService->delete($id);

            return redirect()->back()->with('success', 'Room deleted successfully.');
        } catch (NotFoundHttpException $e) {
            return redirect()->back()->with('error', 'You do not have access to delete this room.');
        } catch (\Exception $e) {
            Log::error('Room deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred while deleting the room.');
        }
    }



}

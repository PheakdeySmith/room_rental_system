<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    use AuthorizesRequests;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = Auth::user();
        if ($user && $user->hasRole('admin')) {
            $users = User::with('landlord')->get();
        } else {
            $users = $this->userService->getAll();
        }

        return view('backends.dashboard.users.index', compact('users'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();

            $user = Auth::user();
            if ($user && $user->hasRole('landlord')) {
                $data['landlord_id'] = $request->input('landlord_id');
            } else {
                $data['landlord_id'] = $user->id;
            }

            $this->userService->create($data);

            return redirect()->route('users.index')->with('success', 'User created successfully.');

        } catch (\Exception $e) {
            // Log the error
            \Log::error('User store error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create user.');
        }
    }
}

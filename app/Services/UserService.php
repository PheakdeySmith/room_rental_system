<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\UserInterface;

class UserService
{
    protected UserInterface $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAll(): Collection
    {
        $authUser = Auth::user();

        if ($authUser->hasRole('admin') || $authUser->hasRole('landlord')) {
            return $this->userRepo->all();
        }

        abort(403, 'Unauthorized action.');
    }


    public function create(array $data): User
    {
        $authUser = Auth::user();

        if ($authUser->hasRole('admin')) {
            return $this->userRepo->create($data);
        }

        if ($authUser->hasRole('landlord')) {
            $data['landlord_id'] = $authUser->id;
            return $this->userRepo->create($data);
        }

        abort(403, 'Unauthorized action.');
    }


    public function update(int $id, array $data): bool
    {
        $authUser = Auth::user();
        $targetUser = $this->userRepo->find($id);

        if ($authUser->hasRole('admin')) {
            return $this->userRepo->update($id, $data);
        }

        if (
            $authUser->hasRole('landlord') &&
            $targetUser->landlord_id === $authUser->id
        ) {
            return $this->userRepo->update($id, $data);
        }

        abort(403, 'Unauthorized action.');
    }

    public function delete(int $id): bool
    {
        $authUser = Auth::user();
        $targetUser = $this->userRepo->find($id);

        if ($authUser->hasRole('admin')) {
            return $this->userRepo->delete($id);
        }

        if (
            $authUser->hasRole('landlord') &&
            $targetUser->landlord_id === $authUser->id
        ) {
            return $this->userRepo->delete($id);
        }

        abort(403, 'Unauthorized action.');
    }

}

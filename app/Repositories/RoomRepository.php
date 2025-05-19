<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoomInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoomRepository implements RoomInterface
{
    public function all(): Collection
    {
        $user = Auth::user();

        $query = Room::with('landlord');

        if ($user && $user->hasRole('landlord')) {
            $query->where('landlord_id', $user->id);
        }

        return $query->get();
    }

    public function find(int $id): Room
    {
        $room = Room::with('landlord')->findOrFail($id);

        $this->authorizeAccess($room);

        return $room;
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $room = Room::findOrFail($id);

        $this->authorizeAccess($room);

        return $room->update($data);
    }

    public function delete(int $id): int
    {
        $room = Room::findOrFail($id);

        $this->authorizeAccess($room);

        return $room->delete();
    }

    private function authorizeAccess(Room $room): void
    {
        $user = Auth::user();

        if ($user && $user->hasRole('admin')) {
            return;
        }

        if ($user->hasRole('landlord') && $room->landlord_id !== $user->id) {
            throw new NotFoundHttpException('Room not found.');
        }
    }
}

<?php

namespace App\Services;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Interfaces\RoomInterface;

class RoomService
{
    protected RoomInterface $roomRepo;

    public function __construct(RoomInterface $roomRepo)
    {
        $this->roomRepo = $roomRepo;
    }

    public function getAll(): Collection
    {
        return $this->roomRepo->all();
    }

    public function create(array $data): Room
    {
        $data['landlord_id'] = Auth::user()->id;
        return $this->roomRepo->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->roomRepo->update($id, $data);
    }
    
    public function delete(int $id): int
    {
        return $this->roomRepo->delete($id);
    }

}

<?php

namespace App\Services;

use App\Repositories\Interfaces\RoomInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;

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
        $data['landlord_id'] = tenant()->id;
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'landlord_id',
        'start_date',
        'end_date',
        'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

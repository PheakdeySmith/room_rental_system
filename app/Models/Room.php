<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Scope;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'property_id',
        'room_type_id',
        'room_number',
        'description',
        'size',
        'floor',
        'status',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_MAINTENANCE = 'maintenance';

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

}

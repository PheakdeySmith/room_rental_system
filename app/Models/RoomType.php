<?php

namespace App\Models;

use App\Models\BasePrice;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'capacity',
        'landlord_id',
        'status',
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room_type');
    }

    public function basePrices()
    {
        return $this->hasMany(BasePrice::class);
    }

    /**
     * Get the current effective base price for the RoomType.
     */
    public function basePrice()
    {
        return $this->hasOne(BasePrice::class)->ofMany('effective_date', 'max');
    }
}

<?php

namespace App\Models;

use App\Models\Amenity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'phone',
        'status',
        'landlord_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class, 'landlord_id');
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class, 'landlord_id');
    }

    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Property::class, 'landlord_id', 'property_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'user_id');
    }

    public function assignContracts()
    {
        return $this->hasMany(Contract::class, 'user_id');
    }

    public function isLandlord(): bool
    {
        return $this->hasRole('landlord');
    }
}

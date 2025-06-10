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
        'number',
        'price',
        'landlord_id',
        'status',
    ];

    const STATUS_AVAILABLE = 'available';
    const STATUS_OCCUPIED = 'occupied';
    const STATUS_MAINTENANCE = 'maintenance';

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}

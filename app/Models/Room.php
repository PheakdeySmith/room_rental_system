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

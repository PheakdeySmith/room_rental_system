<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'start_date',
        'end_date',
        'rent_amount',
        'billing_cycle',
        'status',
        'contract_image',
    ];

    public const BILLING_CYCLE_DAILY = 'daily';
    public const BILLING_CYCLE_MONTHLY = 'monthly';
    public const BILLING_CYCLE_YEARLY = 'yearly';

    /**
     * Get the tenant associated with the contract.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the room associated with the contract.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
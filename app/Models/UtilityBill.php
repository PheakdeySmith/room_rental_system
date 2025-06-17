<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UtilityBill extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
    ];

    /**
     * Get the contract this calculation belongs to.
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get the line item that was created from this utility calculation.
     */
    public function lineItem(): MorphOne
    {
        return $this->morphOne(LineItem::class, 'lineable');
    }
}
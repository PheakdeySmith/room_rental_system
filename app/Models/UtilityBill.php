<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class UtilityBill extends Model
{
    use HasFactory;
    protected $fillable = [
        'contract_id',
        'utility_type_id',
        'billing_period_start',
        'billing_period_end',
        'start_reading',
        'end_reading',
        'consumption',
        'rate_applied',
        'amount',
    ];

    protected $casts = [
        'billing_period_start' => 'date',
        'billing_period_end' => 'date',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function lineItem(): MorphOne
    {
        return $this->morphOne(LineItem::class, 'lineable');
    }
}
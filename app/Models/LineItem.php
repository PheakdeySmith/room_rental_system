<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LineItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the parent invoice that this line item belongs to.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * The magic polymorphic relationship.
     * This can get the parent model (e.g., a UtilityBill) that this line item is linked to.
     * Usage: $lineItem->lineable
     */
    public function lineable(): MorphTo
    {
        return $this->morphTo();
    }
}
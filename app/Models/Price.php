<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends BaseModel
{
    protected $table = 'prices';

    protected $fillable = [
        'type',
        'amount',
        'unit',
        'notes',
        'is_active',
        'media_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'amount'    => 'decimal:2',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}

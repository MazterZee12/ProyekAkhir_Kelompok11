<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $table = 'prices';

    protected $fillable = [
        'type',
        'amount',
        'unit',
        'notes',
        'photo_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
    ];

    // Scope untuk harga aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor format rupiah
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}

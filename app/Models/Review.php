<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'visit_date',
        'rating',
        'comment',
        'is_hidden',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'rating'     => 'float',
        'is_hidden'  => 'boolean',
    ];

    public function isEditable(): bool
    {
        return $this->created_at->gte(now()->subDays(7));
    }

    // ─── Relationships ────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────────────

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
}

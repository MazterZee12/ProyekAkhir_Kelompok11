<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
     protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'reports_count',
        'is_hidden',
        'report_reasons',
    ];

    protected $casts = [
        'rating'         => 'float',
        'is_hidden'      => 'boolean',
        'report_reasons' => 'array',
        'reports_count'  => 'integer',
    ];

    // Threshold laporan sebelum auto-hide
    const REPORT_THRESHOLD = 5;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope: hanya review yang terlihat publik
    public function scopeVisible($query)
    {
        return $query->where(function($q) {
            $q->where('is_hidden', false)
            ->orWhereNull('is_hidden');
        });
    }

    // Scope: review yang dilaporkan
    public function scopeReported($query)
    {
        return $query->where('reports_count', '>', 0);
    }

    // Tambah laporan
    public function addReport(string $reason): void
    {
        $reasons   = $this->report_reasons ?? [];
        $reasons[] = $reason;

        $this->reports_count += 1;
        $this->report_reasons = $reasons;

        // Auto-hide jika laporan >= threshold
        if ($this->reports_count >= self::REPORT_THRESHOLD) {
            $this->is_hidden = true;
        }

        $this->save();
    }
}

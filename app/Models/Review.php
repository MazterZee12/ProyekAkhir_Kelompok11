<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    /**
     * Jumlah laporan sebelum review otomatis disembunyikan.
     */
    public const AUTO_HIDE_THRESHOLD = 5;

    protected $fillable = [
        'user_id',
        'visit_date',
        'rating',
        'comment',
        'is_hidden',
        'reports_count',
        'reported_by',
    ];

    protected $casts = [
        'visit_date'    => 'date',
        'rating'        => 'float',
        'is_hidden'     => 'boolean',
        'reports_count' => 'integer',
        'reported_by'   => 'array',
    ];

    public function isEditable(): bool
    {
        return $this->created_at->gte(now()->subDays(7));
    }

    // Relationship
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scope
    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }

    // Cek apakah user sudah melapor
    public function isReportedByCurrentUser(): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $reportedBy = $this->reported_by ?? [];

        return collect($reportedBy)->contains(
            fn ($report) => $report['user_id'] == Auth::id()
        );
    }

    /**
     * Tambah laporan.
     */
    public function addReport(string $reasonLabel): void
    {
        if ($this->isReportedByCurrentUser()) {
            throw new \RuntimeException(
                'Kamu sudah pernah melaporkan ulasan ini.'
            );
        }

        $reportedBy = $this->reported_by ?? [];

        $reportedBy[] = [
            'user_id'     => Auth::id(),
            'reason'      => $reasonLabel,
            'reported_at' => now()->toDateTimeString(),
        ];

        $this->reported_by = $reportedBy;
        $this->increment('reports_count');
        $this->save();

        if (
            $this->reports_count >= self::AUTO_HIDE_THRESHOLD &&
            !$this->is_hidden
        ) {
            $this->update([
                'is_hidden' => true,
            ]);
        }
    }
}
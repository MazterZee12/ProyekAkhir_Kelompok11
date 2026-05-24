<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    /**
     * Field yang boleh diisi
     */
    protected $fillable = [
        'title',
        'content',
        'type',
        'starts_at',
        'ends_at',
        'photo_path',
        'attachment_path',
        'is_active',
        'is_featured',
        'views',
    ];

    /**
     * Cast otomatis
     */
    protected $casts = [
        'starts_at'   => 'datetime',
        'ends_at'     => 'datetime',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Scope untuk announcement aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * Status dinamis
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return 'scheduled';
        }

        if ($this->ends_at && now()->gt($this->ends_at)) {
            return 'expired';
        }

        return 'active';
    }

    /**
     * Tambah jumlah views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}

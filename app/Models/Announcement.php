<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Announcement extends Model
{
    use SoftDeletes;

    /**
     * Auto generate slug saat create
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($announcement) {

            // Generate slug dari title
            $slug = Str::slug($announcement->title);

            // Cegah slug duplicate
            $count = static::where('slug', 'like', $slug . '%')->count();

            $announcement->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

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
        'slug'
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
     * Scope untuk announcement yang sudah dipublikasikan
     */
    public function scopePublished($query)
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

    /**
     * Auto publish dan auto expire announcement
     */
    public static function autoPublish()
    {
        static::where('is_active', false)
            ->whereNotNull('starts_at')
            ->where('starts_at', '<=', now())
            ->update([
                'is_active' => true
            ]);

        static::where('is_active', true)
            ->whereNotNull('ends_at')
            ->where('ends_at', '<', now())
            ->update([
                'is_active' => false
            ]);
    }
}

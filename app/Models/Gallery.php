<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'file_path',
        'type'
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($gallery) {
            if ($gallery->title) {
                $gallery->slug = Str::slug($gallery->title);
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'description',
        'history',
        'vision',
        'mission',
        'established_year',
        'regulations',
        'photo_path',
        'is_active'
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'established_year'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

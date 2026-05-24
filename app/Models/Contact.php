<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
        protected $fillable = [
        'address',
        'email',
        'phone',
        'google_maps_embed',
        'instagram',
        'facebook',
        'youtube',
        'twitter',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}

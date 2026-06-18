<?php

namespace App\Models;

class Contact extends BaseModel
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
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

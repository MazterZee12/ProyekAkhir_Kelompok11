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
        'twitter',
        'is_active',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function incrementViews()
    {
        $this->increment('views');
    }
}

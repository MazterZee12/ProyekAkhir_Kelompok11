<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'history',
        'vision',
        'mission',
        'established_year',
        'regulations',
        'is_active',
        'media_id',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'established_year' => 'integer',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends BaseModel
{
    protected $fillable = [
        'title',
        'subtitle',
        'order',
        'is_active',
        'media_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}

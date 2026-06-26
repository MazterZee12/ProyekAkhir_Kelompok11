<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'media_id',
        'type',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'description',
        'media_id',
    ];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'type'
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}

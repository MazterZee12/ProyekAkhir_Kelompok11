<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'rating',
        'comment',
        'approved',
        'reports_count',
        'hidden_at',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'hidden_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approved', true)
                     ->whereNull('hidden_at');
    }

    public function scopePending($query)
    {
        return $query->where('approved', false);
    }

    public function scopeHidden($query)
    {
        return $query->whereNotNull('hidden_at');
    }

    public function autoHideIfNecessary()
    {
        if ($this->reports_count >= 3 && is_null($this->hidden_at)) {
            $this->hidden_at = now();
            $this->save();
        }
    }
}

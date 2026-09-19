<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }
}
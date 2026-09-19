<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
        ];
    }

    /**
     * Tickets that belong to this category.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * FAQs that belong to this category.
     */
    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
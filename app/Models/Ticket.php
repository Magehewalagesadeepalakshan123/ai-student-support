<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'subject',
        'description',
        'priority',
        'status',
        'assigned_to',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class)
            ->orderBy('created_at');
    }
}
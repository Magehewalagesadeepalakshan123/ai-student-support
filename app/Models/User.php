<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Fields that can be inserted or updated.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Fields hidden when converting user data to arrays/JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Tickets created by this user/student.
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Tickets assigned to this staff member.
     */
    public function assignedTickets()
    {
        return $this->hasMany(
            Ticket::class,
            'assigned_to'
        );
    }

    /**
     * Ticket replies written by this user.
     */
    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class);
    }
}
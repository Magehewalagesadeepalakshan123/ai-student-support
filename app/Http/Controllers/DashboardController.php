<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function student()
    {
        $userId = auth()->id();

        $totalTickets = Ticket::where('user_id', $userId)
            ->count();

        $pendingTickets = Ticket::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $inProgressTickets = Ticket::where('user_id', $userId)
            ->where('status', 'in_progress')
            ->count();

        $resolvedTickets = Ticket::where('user_id', $userId)
            ->where('status', 'resolved')
            ->count();

        $recentTickets = Ticket::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalTickets',
            'pendingTickets',
            'inProgressTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }


    public function staff()
    {
        $totalTickets = Ticket::count();

        $pendingTickets = Ticket::where('status', 'pending')
            ->count();

        $inProgressTickets = Ticket::where('status', 'in_progress')
            ->count();

        $resolvedTickets = Ticket::where('status', 'resolved')
            ->count();

        $recentTickets = Ticket::with([
            'user',
            'category'
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalTickets',
            'pendingTickets',
            'inProgressTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }
}
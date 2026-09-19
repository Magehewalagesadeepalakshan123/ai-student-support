<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\AiQuestion;

class DashboardController extends Controller
{
    // =========================================
    // STUDENT DASHBOARD
    // =========================================
    public function student()
    {
        $userId = auth()->id();


        // Total Tickets
        $totalTickets = Ticket::where(
            'user_id',
            $userId
        )->count();


        // Pending Tickets
        $pendingTickets = Ticket::where(
            'user_id',
            $userId
        )
            ->where('status', 'pending')
            ->count();


        // In Progress Tickets
        $inProgressTickets = Ticket::where(
            'user_id',
            $userId
        )
            ->where('status', 'in_progress')
            ->count();


        // Resolved Tickets
        $resolvedTickets = Ticket::where(
            'user_id',
            $userId
        )
            ->where('status', 'resolved')
            ->count();


        // AI Question Count
        $aiQuestionsCount = AiQuestion::where(
            'user_id',
            $userId
        )->count();


        // Recent Tickets
        $recentTickets = Ticket::with('category')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();


        return view(
            'student.dashboard',
            compact(
                'totalTickets',
                'pendingTickets',
                'inProgressTickets',
                'resolvedTickets',
                'aiQuestionsCount',
                'recentTickets'
            )
        );
    }


    // =========================================
    // STAFF DASHBOARD
    // =========================================
    public function staff()
    {
        $totalTickets = Ticket::count();

        $pendingTickets = Ticket::where(
            'status',
            'pending'
        )->count();

        $inProgressTickets = Ticket::where(
            'status',
            'in_progress'
        )->count();

        $resolvedTickets = Ticket::where(
            'status',
            'resolved'
        )->count();

        $recentTickets = Ticket::with([
            'user',
            'category'
        ])
            ->latest()
            ->take(5)
            ->get();


        return view(
            'staff.dashboard',
            compact(
                'totalTickets',
                'pendingTickets',
                'inProgressTickets',
                'resolvedTickets',
                'recentTickets'
            )
        );
    }
}
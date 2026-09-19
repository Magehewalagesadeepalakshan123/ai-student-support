<?php

namespace App\Http\Controllers;

use App\Models\AiQuestion;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;

class AdminReportController extends Controller
{
    public function index()
    {
        // =========================================
        // USER STATISTICS
        // =========================================

        $studentsCount = User::where(
            'role',
            'student'
        )->count();

        $staffCount = User::where(
            'role',
            'staff'
        )->count();


        // =========================================
        // TICKET STATISTICS
        // =========================================

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

        $closedTickets = Ticket::where(
            'status',
            'closed'
        )->count();


        // =========================================
        // AI STATISTICS
        // =========================================

        $totalAiQuestions = AiQuestion::count();

        $answeredAiQuestions = AiQuestion::where(
            'found_answer',
            true
        )->count();

        $unansweredAiQuestions = AiQuestion::where(
            'found_answer',
            false
        )->count();


        // =========================================
        // AI SUCCESS RATE
        // =========================================

        if ($totalAiQuestions > 0) {

            $aiSuccessRate = round(
                (
                    $answeredAiQuestions
                    / $totalAiQuestions
                ) * 100,
                1
            );

        } else {

            $aiSuccessRate = 0;
        }


        // =========================================
        // POPULAR CATEGORIES
        // =========================================

        $popularCategories = Category::withCount(
            'tickets'
        )
            ->orderByDesc('tickets_count')
            ->take(5)
            ->get();


        // =========================================
        // RECENT TICKETS
        // =========================================

        $recentTickets = Ticket::with([
            'user',
            'category',
            'assignedStaff'
        ])
            ->latest()
            ->take(10)
            ->get();


        // =========================================
        // RECENT UNANSWERED AI QUESTIONS
        // =========================================

        $recentUnansweredQuestions = AiQuestion::with(
            'user'
        )
            ->where(
                'found_answer',
                false
            )
            ->latest()
            ->take(10)
            ->get();


        return view(
            'admin.reports',
            compact(
                'studentsCount',
                'staffCount',
                'totalTickets',
                'pendingTickets',
                'inProgressTickets',
                'resolvedTickets',
                'closedTickets',
                'totalAiQuestions',
                'answeredAiQuestions',
                'unansweredAiQuestions',
                'aiSuccessRate',
                'popularCategories',
                'recentTickets',
                'recentUnansweredQuestions'
            )
        );
    }
}
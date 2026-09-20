<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\AiQuestion;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Notice;
use App\Models\KnowledgeArticle;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =========================================
        // USERS
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
        // TICKETS
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
        // AI QUESTIONS
        // =========================================

        $aiQuestionsCount = AiQuestion::count();

        $unansweredAiCount = AiQuestion::where(
            'found_answer',
            false
        )->count();


        // =========================================
        // SYSTEM CONTENT
        // =========================================

        $categoriesCount = Category::count();

        $faqsCount = Faq::count();

        $noticesCount = Notice::count();

        $knowledgeArticlesCount =
            KnowledgeArticle::count();


        // =========================================
        // CATEGORY CHART
        // =========================================

        $categoryStats = Category::withCount(
            'tickets'
        )
            ->orderByDesc('tickets_count')
            ->get();


        $categoryNames =
            $categoryStats->pluck('name');


        $categoryTicketCounts =
            $categoryStats->pluck(
                'tickets_count'
            );


        // =========================================
        // RECENT TICKETS
        // =========================================

        $recentTickets = Ticket::with([
            'user',
            'category'
        ])
            ->latest()
            ->take(5)
            ->get();


        // =========================================
        // RECENT AI QUESTIONS
        // =========================================

        $recentAiQuestions = AiQuestion::with(
            'user'
        )
            ->latest()
            ->take(5)
            ->get();


        // =========================================
        // SEND EVERYTHING TO DASHBOARD
        // =========================================

        return view(
            'admin.dashboard',
            compact(
                'studentsCount',
                'staffCount',
                'totalTickets',
                'pendingTickets',
                'inProgressTickets',
                'resolvedTickets',
                'closedTickets',
                'aiQuestionsCount',
                'unansweredAiCount',
                'categoriesCount',
                'faqsCount',
                'noticesCount',
                'knowledgeArticlesCount',
                'categoryNames',
                'categoryTicketCounts',
                'recentTickets',
                'recentAiQuestions'
            )
        );
    }
}
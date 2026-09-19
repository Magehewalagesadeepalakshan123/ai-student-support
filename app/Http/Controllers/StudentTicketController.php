<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class StudentTicketController extends Controller
{
    // =========================================
    // SHOW STUDENT'S TICKETS
    // =========================================
    public function index()
    {
        $tickets = Ticket::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'student.tickets',
            compact('tickets')
        );
    }


    // =========================================
    // CREATE TICKET PAGE
    // =========================================
    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'student.create-ticket',
            compact('categories')
        );
    }


    // =========================================
    // STORE TICKET
    // =========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:categories,id'
            ],

            'subject' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'required',
                'string',
                'max:5000'
            ],

            'priority' => [
                'required',
                'in:low,normal,high'
            ],
        ]);


        Ticket::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'pending',
        ]);


        return redirect()
            ->route('student.tickets')
            ->with(
                'success',
                'Support ticket created successfully.'
            );
    }


    // =========================================
    // SHOW ONE TICKET
    // =========================================
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $ticket->load([
            'category',
            'assignedStaff',
            'replies.user'
        ]);

        return view(
            'student.ticket-show',
            compact('ticket')
        );
    }


    // =========================================
    // STUDENT REPLY
    // =========================================
    public function reply(
        Request $request,
        Ticket $ticket
    ) {
        if ($ticket->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $validated = $request->validate([
            'message' => [
                'required',
                'string',
                'max:5000'
            ],
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return back()->with(
            'success',
            'Your reply was sent successfully.'
        );
    }
}
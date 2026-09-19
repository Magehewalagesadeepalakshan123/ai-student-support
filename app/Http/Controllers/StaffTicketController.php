<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class StaffTicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with([
            'user',
            'category',
            'assignedStaff'
        ])
        ->latest()
        ->get();

        return view(
            'staff.tickets',
            compact('tickets')
        );
    }


    public function show(Ticket $ticket)
    {
        $ticket->load([
            'user',
            'category',
            'assignedStaff',
            'replies.user'
        ]);

        return view(
            'staff.ticket-show',
            compact('ticket')
        );
    }


    public function assign(Ticket $ticket)
    {
        $ticket->update([
            'assigned_to' => auth()->id(),
            'status' => 'in_progress',
        ]);

        return back()->with(
            'success',
            'Ticket assigned to you successfully.'
        );
    }


    public function updateStatus(
        Request $request,
        Ticket $ticket
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,in_progress,resolved,closed'
            ],
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Ticket status updated successfully.'
        );
    }


    public function reply(
        Request $request,
        Ticket $ticket
    ) {
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

        if ($ticket->status === 'pending') {
            $ticket->update([
                'status' => 'in_progress',
            ]);
        }

        return back()->with(
            'success',
            'Reply sent successfully.'
        );
    }
}
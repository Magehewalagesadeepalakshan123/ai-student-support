<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class AdminNoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()
            ->paginate(10);

        return view(
            'admin.notices.index',
            compact('notices')
        );
    }


    public function create()
    {
        return view('admin.notices.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'content' => [
                'required',
                'string',
                'max:5000'
            ],

            'published_at' => [
                'nullable',
                'date'
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:published_at'
            ],
        ]);

        Notice::create([
            'title' => $validated['title'],
            'content' => $validated['content'],

            'published_at' =>
                $validated['published_at'] ?? now(),

            'expires_at' =>
                $validated['expires_at'] ?? null,

            'status' => true,
        ]);

        return redirect()
            ->route('admin.notices.index')
            ->with(
                'success',
                'Notice created successfully.'
            );
    }


    public function edit(Notice $notice)
    {
        return view(
            'admin.notices.edit',
            compact('notice')
        );
    }


    public function update(
        Request $request,
        Notice $notice
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'content' => [
                'required',
                'string',
                'max:5000'
            ],

            'published_at' => [
                'nullable',
                'date'
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:published_at'
            ],
        ]);

        $notice->update($validated);

        return redirect()
            ->route('admin.notices.index')
            ->with(
                'success',
                'Notice updated successfully.'
            );
    }


    public function toggleStatus(Notice $notice)
    {
        $notice->update([
            'status' => !$notice->status
        ]);

        return back()->with(
            'success',
            'Notice status updated.'
        );
    }


    public function destroy(Notice $notice)
    {
        $notice->delete();

        return back()->with(
            'success',
            'Notice deleted successfully.'
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Notice;

class StudentNoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::where('status', true)

            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere(
                        'published_at',
                        '<=',
                        now()
                    );
            })

            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere(
                        'expires_at',
                        '>=',
                        now()
                    );
            })

            ->latest('published_at')
            ->get();

        return view(
            'student.notices',
            compact('notices')
        );
    }
}
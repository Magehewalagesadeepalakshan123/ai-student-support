<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use Illuminate\Http\Request;

class StudentFaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Faq::with('category')
            ->where('status', true);

        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'question',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'answer',
                    'like',
                    "%{$search}%"
                );

            });
        }

        $faqs = $query
            ->latest()
            ->get();

        $categories = Category::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'student.faqs',
            compact(
                'faqs',
                'categories'
            )
        );
    }
}
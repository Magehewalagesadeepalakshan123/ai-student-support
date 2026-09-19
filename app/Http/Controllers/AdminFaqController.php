<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Faq;
use Illuminate\Http\Request;

class AdminFaqController extends Controller
{
    // ========================================
    // FAQ LIST
    // ========================================

    public function index()
    {
        $faqs = Faq::with('category')
            ->latest()
            ->paginate(10);

        return view(
            'admin.faqs.index',
            compact('faqs')
        );
    }


    // ========================================
    // CREATE PAGE
    // ========================================

    public function create()
    {
        $categories = Category::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.faqs.create',
            compact('categories')
        );
    }


    // ========================================
    // SAVE FAQ
    // ========================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'question' => [
                'required',
                'string',
                'max:500',
            ],

            'answer' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        Faq::create([
            'category_id' =>
                $validated['category_id'] ?? null,

            'question' =>
                $validated['question'],

            'answer' =>
                $validated['answer'],

            'status' => true,
        ]);

        return redirect()
            ->route('admin.faqs.index')
            ->with(
                'success',
                'FAQ created successfully.'
            );
    }


    // ========================================
    // EDIT PAGE
    // ========================================

    public function edit(Faq $faq)
    {
        $categories = Category::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.faqs.edit',
            compact(
                'faq',
                'categories'
            )
        );
    }


    // ========================================
    // UPDATE FAQ
    // ========================================

    public function update(
        Request $request,
        Faq $faq
    ) {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'question' => [
                'required',
                'string',
                'max:500',
            ],

            'answer' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        $faq->update([
            'category_id' =>
                $validated['category_id'] ?? null,

            'question' =>
                $validated['question'],

            'answer' =>
                $validated['answer'],
        ]);

        return redirect()
            ->route('admin.faqs.index')
            ->with(
                'success',
                'FAQ updated successfully.'
            );
    }


    // ========================================
    // ACTIVATE / DEACTIVATE
    // ========================================

    public function toggleStatus(Faq $faq)
    {
        $faq->update([
            'status' => !$faq->status,
        ]);

        return back()->with(
            'success',
            'FAQ status updated successfully.'
        );
    }


    // ========================================
    // DELETE FAQ
    // ========================================

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with(
            'success',
            'FAQ deleted successfully.'
        );
    }
}
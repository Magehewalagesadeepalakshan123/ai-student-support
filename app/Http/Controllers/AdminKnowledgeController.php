<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\KnowledgeArticle;
use Illuminate\Http\Request;

class AdminKnowledgeController extends Controller
{
    // =========================================
    // LIST ARTICLES
    // =========================================
    public function index()
    {
        $articles = KnowledgeArticle::with('category')
            ->latest()
            ->paginate(10);

        return view(
            'admin.knowledge.index',
            compact('articles')
        );
    }


    // =========================================
    // CREATE PAGE
    // =========================================
    public function create()
    {
        $categories = Category::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.knowledge.create',
            compact('categories')
        );
    }


    // =========================================
    // SAVE ARTICLE
    // =========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
                'max:10000',
            ],

            'keywords' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        KnowledgeArticle::create([
            'category_id' =>
                $validated['category_id'] ?? null,

            'title' =>
                $validated['title'],

            'content' =>
                $validated['content'],

            'keywords' =>
                $validated['keywords'] ?? null,

            'status' => true,
        ]);

        return redirect()
            ->route('admin.knowledge.index')
            ->with(
                'success',
                'Knowledge article created successfully.'
            );
    }


    // =========================================
    // EDIT PAGE
    // =========================================
    public function edit(KnowledgeArticle $article)
    {
        $categories = Category::where(
            'status',
            true
        )
            ->orderBy('name')
            ->get();

        return view(
            'admin.knowledge.edit',
            compact(
                'article',
                'categories'
            )
        );
    }


    // =========================================
    // UPDATE ARTICLE
    // =========================================
    public function update(
        Request $request,
        KnowledgeArticle $article
    ) {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'content' => [
                'required',
                'string',
                'max:10000',
            ],

            'keywords' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);

        $article->update([
            'category_id' =>
                $validated['category_id'] ?? null,

            'title' =>
                $validated['title'],

            'content' =>
                $validated['content'],

            'keywords' =>
                $validated['keywords'] ?? null,
        ]);

        return redirect()
            ->route('admin.knowledge.index')
            ->with(
                'success',
                'Knowledge article updated successfully.'
            );
    }


    // =========================================
    // ACTIVATE / DEACTIVATE
    // =========================================
    public function toggleStatus(
        KnowledgeArticle $article
    ) {
        $article->update([
            'status' => !$article->status,
        ]);

        return back()->with(
            'success',
            'Article status updated successfully.'
        );
    }


    // =========================================
    // DELETE ARTICLE
    // =========================================
    public function destroy(
        KnowledgeArticle $article
    ) {
        $article->delete();

        return back()->with(
            'success',
            'Knowledge article deleted successfully.'
        );
    }
}
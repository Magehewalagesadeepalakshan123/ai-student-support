<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    // ========================================
    // CATEGORY LIST
    // ========================================

    public function index()
    {
        $categories = Category::withCount('tickets')
            ->latest()
            ->paginate(10);

        return view(
            'admin.categories.index',
            compact('categories')
        );
    }


    // ========================================
    // CREATE PAGE
    // ========================================

    public function create()
    {
        return view('admin.categories.create');
    }


    // ========================================
    // SAVE CATEGORY
    // ========================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        Category::create([
            'name' => $validated['name'],
            'description' =>
                $validated['description'] ?? null,
            'status' => true,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category created successfully.'
            );
    }


    // ========================================
    // EDIT PAGE
    // ========================================

    public function edit(Category $category)
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }


    // ========================================
    // UPDATE CATEGORY
    // ========================================

    public function update(
        Request $request,
        Category $category
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',

                Rule::unique('categories', 'name')
                    ->ignore($category->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $category->update([
            'name' => $validated['name'],

            'description' =>
                $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    // ========================================
    // ACTIVATE / DEACTIVATE
    // ========================================

    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => !$category->status,
        ]);

        return back()->with(
            'success',
            'Category status updated successfully.'
        );
    }


    // ========================================
    // DELETE CATEGORY
    // ========================================

    public function destroy(Category $category)
    {
        if ($category->tickets()->exists()) {

            return back()->with(
                'error',
                'This category cannot be deleted because tickets are using it.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Category deleted successfully.'
        );
    }
}
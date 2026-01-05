<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RevenueCategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = RevenueCategory::latest()->get(); // get all categories
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:revenue_categories,name',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        RevenueCategory::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'],
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Revenue category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(RevenueCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, RevenueCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:revenue_categories,name,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',
        ]);

        $category->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Revenue category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(RevenueCategory $category)
    {
        // Optional: prevent deleting if items exist
        if (method_exists($category, 'items') && $category->items()->exists()) {
            abort(409, 'Cannot delete category with revenue items.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Revenue category deleted successfully.');
    }
}

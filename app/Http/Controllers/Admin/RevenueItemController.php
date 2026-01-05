<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RevenueItem;
use App\Models\RevenueCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RevenueItemController extends Controller
{
    public function index()
    {
        $items = RevenueItem::with('category')->get();
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        $categories = RevenueCategory::where('is_active', true)->get();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:revenue_categories,id',
            'name' => 'required|string|max:255|unique:revenue_items,name',
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50',
            'calculation_type' => 'required|in:fixed,formula,variable',
            'amount' => 'nullable|numeric|min:0',
            'payment_frequency' => 'required|in:once,monthly,quarterly,annual',
            'penalty_rate' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        RevenueItem::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'code' => $validated['code'] ?? null,
            'calculation_type' => $validated['calculation_type'],
            'amount' => $validated['amount'] ?? 0,
            'payment_frequency' => $validated['payment_frequency'],
            'penalty_rate' => $validated['penalty_rate'] ?? 0,
            'is_active' => $validated['is_active'],
            'created_by' => $request->user()->id,
        ]);

        return redirect()->route('admin.items.index')
                         ->with('success', 'Revenue item created successfully.');
    }

    public function edit(RevenueItem $item)
    {
        $categories = RevenueCategory::where('is_active', true)->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, RevenueItem $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:revenue_categories,id',
            'name' => 'required|string|max:255|unique:revenue_items,name,' . $item->id,
            'description' => 'nullable|string',
            'code' => 'nullable|string|max:50',
            'calculation_type' => 'required|in:fixed,formula,variable',
            'amount' => 'nullable|numeric|min:0',
            'payment_frequency' => 'required|in:once,monthly,quarterly,annual',
            'penalty_rate' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $item->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'code' => $validated['code'] ?? null,
            'calculation_type' => $validated['calculation_type'],
            'amount' => $validated['amount'] ?? 0,
            'payment_frequency' => $validated['payment_frequency'],
            'penalty_rate' => $validated['penalty_rate'] ?? 0,
            'is_active' => $validated['is_active'],
        ]);

        return redirect()->route('admin.items.index')
                         ->with('success', 'Revenue item updated successfully.');
    }

    public function destroy(RevenueItem $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index')
                         ->with('success', 'Revenue item deleted successfully.');
    }
}

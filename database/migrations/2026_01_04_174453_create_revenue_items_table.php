public function store(Request $request)
{
    $validated = $request->validate([
        'category_id' => 'required|exists:revenue_categories,id',
        'code' => 'nullable|string|max:50',
        'name' => 'required|string|max:255|unique:revenue_items,name',
        'description' => 'nullable|string',
        'calculation_type' => 'required|in:fixed,formula,variable',
        'amount' => 'nullable|numeric|min:0',
        'payment_frequency' => 'required|in:once,monthly,quarterly,annual',
        'penalty_rate' => 'nullable|numeric|min:0',
        'is_active' => 'required|boolean',
        'metadata' => 'nullable|array',
    ]);

    RevenueItem::create([
        'category_id' => $validated['category_id'],
        'code' => $validated['code'] ?? null,
        'name' => $validated['name'],
        'slug' => Str::slug($validated['name']),
        'description' => $validated['description'] ?? null,
        'calculation_type' => $validated['calculation_type'],
        'amount' => $validated['amount'] ?? 0,
        'payment_frequency' => $validated['payment_frequency'],
        'penalty_rate' => $validated['penalty_rate'] ?? 0,
        'metadata' => $validated['metadata'] ?? null,
        'is_active' => $validated['is_active'],
        'created_by' => $request->user()->id,
    ]);

    return redirect()->route('admin.items.index')
                     ->with('success', 'Revenue item created successfully.');
}

public function update(Request $request, RevenueItem $item)
{
    $validated = $request->validate([
        'category_id' => 'required|exists:revenue_categories,id',
        'code' => 'nullable|string|max:50',
        'name' => 'required|string|max:255|unique:revenue_items,name,' . $item->id,
        'description' => 'nullable|string',
        'calculation_type' => 'required|in:fixed,formula,variable',
        'amount' => 'nullable|numeric|min:0',
        'payment_frequency' => 'required|in:once,monthly,quarterly,annual',
        'penalty_rate' => 'nullable|numeric|min:0',
        'is_active' => 'required|boolean',
        'metadata' => 'nullable|array',
    ]);

    $item->update([
        'category_id' => $validated['category_id'],
        'code' => $validated['code'] ?? null,
        'name' => $validated['name'],
        'slug' => Str::slug($validated['name']),
        'description' => $validated['description'] ?? null,
        'calculation_type' => $validated['calculation_type'],
        'amount' => $validated['amount'] ?? 0,
        'payment_frequency' => $validated['payment_frequency'],
        'penalty_rate' => $validated['penalty_rate'] ?? 0,
        'metadata' => $validated['metadata'] ?? null,
        'is_active' => $validated['is_active'],
    ]);

    return redirect()->route('admin.items.index')
                     ->with('success', 'Revenue item updated successfully.');
}

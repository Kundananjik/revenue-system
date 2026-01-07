<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Payer</label>
        <select name="user_id" class="w-full border-gray-300 rounded p-2.5">
            @foreach(App\Models\User::all() as $user)
                <option value="{{ $user->id }}" {{ isset($payment) && $payment->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Revenue Item</label>
        <select name="revenue_item_id" class="w-full border-gray-300 rounded p-2.5">
            @foreach(App\Models\RevenueItem::all() as $item)
                <option value="{{ $item->id }}" {{ isset($payment) && $payment->revenue_item_id == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Amount</label>
        <input type="number" name="amount" step="0.01" value="{{ old('amount', $payment->amount ?? '') }}" class="w-full border-gray-300 rounded p-2.5">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Penalty Amount</label>
        <input type="number" name="penalty_amount" step="0.01" value="{{ old('penalty_amount', $payment->penalty_amount ?? '') }}" class="w-full border-gray-300 rounded p-2.5">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="w-full border-gray-300 rounded p-2.5">
            @foreach(['pending','paid','failed'] as $status)
                <option value="{{ $status }}" {{ isset($payment) && $payment->status == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Paid At</label>
        <input type="datetime-local" name="paid_at" value="{{ isset($payment->paid_at) ? $payment->paid_at->format('Y-m-d\TH:i') : '' }}" class="w-full border-gray-300 rounded p-2.5">
    </div>
</div>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'revenue_item_id',
        'payment_id',
        'amount',
        'rate',
        'reason',
        'applied_at',
        'is_paid',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'is_paid' => 'boolean',
        'amount' => 'decimal:2',
        'rate' => 'decimal:4',
    ];

    public function revenueItem()
    {
        return $this->belongsTo(RevenueItem::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}

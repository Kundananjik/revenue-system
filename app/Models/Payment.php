<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'revenue_item_id',
        'amount',
        'penalty_amount',
        'status',
        'payment_method',
        'reference',
        'collected_by',
        'paid_at',
        'transaction_details',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'transaction_details' => 'array',
        'amount' => 'decimal:2',
        'penalty_amount' => 'decimal:2',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function revenueItem()
    {
        return $this->belongsTo(RevenueItem::class);
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
}

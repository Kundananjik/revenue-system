<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'code',
        'name',
        'description',
        'calculation_type',
        'amount',
        'payment_frequency',
        'penalty_rate',
        'metadata',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'amount' => 'decimal:2',
        'penalty_rate' => 'decimal:4',
    ];

    public function category()
    {
        return $this->belongsTo(RevenueCategory::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

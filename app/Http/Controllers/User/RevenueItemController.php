<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RevenueItem;

class RevenueItemController extends Controller
{
    public function index()
    {
        $items = RevenueItem::latest()->paginate(10);

        return view('user.items.index', compact('items'));
    }
}

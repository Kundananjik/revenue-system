<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Penalty;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::whereHas('payment', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->paginate(10);

        return view('user.penalties.index', compact('penalties'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class leaderboardController extends Controller
{
    public function leaderboard()
    {
        return view('leaderboard.leaderboard');
    }
}

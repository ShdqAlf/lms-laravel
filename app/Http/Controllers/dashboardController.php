<?php

namespace App\Http\Controllers;

use App\Models\Course;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
    public function dashboard()
    {
        $courses = Course::all();
        return view('dashboard.dashboard', compact('courses'));
    }
}

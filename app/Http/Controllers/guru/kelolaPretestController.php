<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class kelolaPretestController extends Controller
{
    public function kelolepretest()
    {
        return view('admin.kelolapretest');
    }
}

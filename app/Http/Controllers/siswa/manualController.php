<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\manualBook;

class manualController extends Controller
{
    public function manualBook()
    {
        // Ambil data manual book terakhir yang diupload
        $manualBook = manualBook::orderBy('created_at', 'desc')->first(); // Ambil file terakhir yang diupload
    
        // Tampilkan halaman dengan data manual book
        return view('siswa.manualbook', compact('manualBook'));
    }
}

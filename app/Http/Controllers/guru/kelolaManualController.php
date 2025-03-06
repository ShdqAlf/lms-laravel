<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\manualBook;

class kelolaManualController extends Controller
{
    public function kelolaManual()
    {
        // Ambil data manual book terakhir yang diupload
        $manualBook = manualBook::orderBy('created_at', 'desc')->first(); // Ambil file terakhir yang diupload
    
        // Tampilkan halaman dengan data manual book
        return view('guru.kelolamanualbook', compact('manualBook'));
    }


    public function store(Request $request)
    {
        // Validasi input jika perlu
        $request->validate([
            'file_manualbook' => 'required|file|mimes:pdf|max:2048', // Validasi file PDF
        ]);
    
        // Update atau Tambahkan Modul
        if ($request->hasFile('file_manualbook')) {
            $file = $request->file('file_manualbook');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destination = base_path('../public_html/storage/manualbook_files'); // 
            
            // Pastikan folder ada, jika tidak buat
            if (!file_exists($destination)) {
                mkdir($destination, 0775, true); // Buat folder jika belum ada
            }
            
            // Pindahkan file ke folder yang sudah ditentukan
            $file->move($destination, $filename);
    
            manualBook::updateOrCreate(
                ['id' => 1],
                ['file_manualbook' => 'storage/manualbook_files/' . $filename] // Data yang akan diupdate atau ditambahkan
            );

        }
    
        return redirect()->route('kelolamanualbook')->with('success', 'Data berhasil disimpan!');
    }

}

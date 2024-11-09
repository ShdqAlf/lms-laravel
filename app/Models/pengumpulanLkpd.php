<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengumpulanLkpd extends Model
{
    use HasFactory;

    protected $table = 'pengumpulan_lkpd'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'course_id',
        'nama_file',
        'file_jawaban'
    ];
}

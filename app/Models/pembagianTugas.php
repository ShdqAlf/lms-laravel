<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembagianTugas extends Model
{
    use HasFactory;

    protected $table = 'pembagian_tugas'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'course_id',
        'soal_id',
        'anggota_id',
    ];
}

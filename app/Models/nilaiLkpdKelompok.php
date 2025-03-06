<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiLkpdKelompok extends Model
{
    use HasFactory;

    protected $table = 'nilai_lkpd_kelompok'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'lkpd_kelompok_id',
        'score',
    ];
}

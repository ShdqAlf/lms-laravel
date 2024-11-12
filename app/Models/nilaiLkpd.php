<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiLkpd extends Model
{
    use HasFactory;

    protected $table = 'nilai_lkpd'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'lkpd_id',
        'score',
    ];
}

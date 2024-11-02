<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPostest extends Model
{
    use HasFactory;

    protected $table = 'nilai_postest'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'postest_id',
        'score',
    ];
}

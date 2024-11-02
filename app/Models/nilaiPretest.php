<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiPretest extends Model
{
    use HasFactory;

    protected $table = 'nilai_pretest'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'pretest_id',
        'score',
    ];
}

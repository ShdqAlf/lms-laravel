<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lkpdKelompok extends Model
{
    use HasFactory;

    protected $table = 'lkpd_kelompok';

    protected $fillable = [
        'soal_lkpd',
        'course_id',
    ];
}

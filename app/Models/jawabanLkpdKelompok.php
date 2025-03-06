<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawabanLkpdKelompok extends Model
{
    use HasFactory;

    protected $table = 'jawaban_lkpd';

    protected $fillable = [
        'lkpd_kelompok_id',
        'user_id',
        'jawaban',
    ];

    // Relasi dengan model postest
    public function lkpdKelompok()
    {
        return $this->belongsTo(lkpdKelompok::class, 'lkpd_kelompok_id');
    }

    // Relasi dengan model User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

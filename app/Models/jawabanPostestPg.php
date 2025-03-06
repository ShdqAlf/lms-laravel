<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jawabanPostestPg extends Model
{
    use HasFactory;

    protected $table = 'jawaban_postest_pg';

    protected $fillable = [
        'postest_pg_id',
        'user_id',
        'jawaban',
    ];

    // Relasi dengan model postest
    public function postest()
    {
        return $this->belongsTo(Postest::class, 'postest_pg_id');
    }

    // Relasi dengan model User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

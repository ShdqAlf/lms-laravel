<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPostest extends Model
{
    use HasFactory;

    protected $table = 'jawaban_postest';

    protected $fillable = [
        'postest_id',
        'user_id',
        'jawaban',
    ];

    // Relasi dengan model postest
    public function postest()
    {
        return $this->belongsTo(Postest::class, 'postest_id');
    }

    // Relasi dengan model User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

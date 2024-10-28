<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanPretest extends Model
{
    use HasFactory;

    protected $table = 'jawaban_pretest';

    protected $fillable = [
        'pretest_id',
        'user_id',
        'jawaban',
    ];

    // Relasi dengan model Pretest
    public function pretest()
    {
        return $this->belongsTo(Pretest::class, 'pretest_id');
    }

    // Relasi dengan model User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

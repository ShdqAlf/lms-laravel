<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'nomor_id',
        'password',
        'role',
        'course_id',
        'kelompok_id',
        'is_ketua',
        'course_opened',
        'materi_opened'
    ];

    // Relasi Many-to-One dengan Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Relasi Many-to-One dengan Kelompok
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

    // Model User
    public function jawabanLkpdKelompok()
    {
        return $this->hasMany(jawabanLkpdKelompok::class, 'user_id');
    }
}

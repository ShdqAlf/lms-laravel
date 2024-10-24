<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang bisa diisi (fillable).
     */
    protected $fillable = [
        'nama',
        'nomor_id',
        'password',
        'role',
        'course_id', // Menyimpan course_id untuk relasi ke tabel courses
    ];

    /**
     * Relasi dengan model Course (many-to-one).
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}

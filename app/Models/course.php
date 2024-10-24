<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (fillable).
     */
    protected $fillable = ['course'];

    /**
     * Relasi dengan model User (one-to-many).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'course_id');
    }
}

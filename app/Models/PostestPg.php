<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostestPg extends Model
{
    use HasFactory;

    protected $table = 'postest_pg';  // The table name

    protected $fillable = [
        'soal_postest',
        'opsi_a',
        'opsi_b',
        'opsi_c',
        'opsi_d',
        'is_correct',
        'course_id',
    ];

    // Relasi Many-to-One dengan Course
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}

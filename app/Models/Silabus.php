<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Silabus extends Model
{
    use HasFactory;

    protected $table = 'silabus';

    protected $fillable = [
        'deskripsi_silabus',
        'course_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pretest extends Model
{
    use HasFactory;

    protected $table = 'pretest';

    protected $fillable = [
        'soal_pretest',
        'course_id',
    ];
}

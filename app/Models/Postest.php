<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postest extends Model
{
    use HasFactory;

    protected $table = 'postest';

    protected $fillable = [
        'soal_postest',
        'course_id',
    ];
}

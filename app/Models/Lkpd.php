<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lkpd extends Model
{
    use HasFactory;

    protected $table = 'lkpd';

    protected $fillable = [
        'deskripsi_lkpd',
        'pdf_lkpd',
        'course_id',
    ];
}

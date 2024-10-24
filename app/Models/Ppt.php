<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppt extends Model
{
    use HasFactory;

    protected $table = 'ppt';

    protected $fillable = [
        'judul_ppt',
        'link_ppt',
        'course_id',
    ];
}

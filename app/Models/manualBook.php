<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manualBook extends Model
{
    use HasFactory;

    protected $table = 'manual_book';

    protected $fillable = [
        'file_manualbook',
    ];
}

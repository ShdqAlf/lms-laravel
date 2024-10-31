<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiPretest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pretest_id',
        'score',
    ];

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship to Pretest
    public function pretest()
    {
        return $this->belongsTo(Pretest::class);
    }
}

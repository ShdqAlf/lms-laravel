<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelompok',
    ];

    protected $table = 'kelompok';

    // Relasi One-to-Many dengan User
    public function users()
    {
        return $this->hasMany(User::class, 'kelompok_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran'; // Sesuaikan dengan tabel yang benar

    protected $fillable = [
        'user_id',
        'status_kehadiran',
        'tanggal_masuk',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mengecek apakah user sudah hadir hari ini.
     */
    public static function checkAttendance($userId)
    {
        return self::where('user_id', $userId)
            ->whereDate('tanggal_masuk', Carbon::today())
            ->exists();
    }
}

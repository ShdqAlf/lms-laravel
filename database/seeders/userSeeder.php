<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert data ke tabel courses
        $courseIdMatematika = DB::table('courses')->insertGetId([
            'course' => 'Matematika',
        ]);

        // Insert data ke tabel users
        DB::table('users')->insert([
            [
                'nama' => 'Admin',
                'nomor_id' => '000',
                'password' => Hash::make('password_admin'), // Hash password
                'role' => 'admin',
                'course_id' => null,
            ],
            [
                'nama' => 'Guru 1',
                'nomor_id' => '001',
                'password' => Hash::make('password_guru'), // Hash password
                'role' => 'guru',
                'course_id' => $courseIdMatematika, // Menggunakan course_id dari tabel courses
            ],
            [
                'nama' => 'Siswa 1',
                'nomor_id' => '002',
                'password' => Hash::make('password_siswa'), // Hash password
                'role' => 'siswa',
                'course_id' => null,
            ],
        ]);
    }
}

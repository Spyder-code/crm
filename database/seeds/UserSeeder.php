<?php

use App\User;
use Illuminate\Database\Seeder;
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
        User::create([
            'name' => 'Muhammad Aziz Almi',
            'panggilan' => 'Almi',
            'jenis_kelamin' => 'LK',
            'tanggal_lahir' => '1999-05-13',
            'kode' => 'AL1301',
            'email' => 'almi@yahoo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'image' => 'http://127.0.0.1:8000/storage/images/user/default.jpg',
            'phone' => '098789927',
            'alamat' => 'mojokerto',
            'status' => 0,
            'komisi' => 0,
        ]);
        User::create([
            'name' => 'Luaysyauqillah',
            'panggilan' => 'Luay',
            'jenis_kelamin' => 'LK',
            'tanggal_lahir' => '1999-05-13',
            'kode' => 'LU1302',
            'email' => 'luay@yahoo.com',
            'password' => Hash::make('admin123'),
            'role' => 'member',
            'image' => 'http://127.0.0.1:8000/storage/images/user/default.jpg',
            'phone' => '098789927',
            'alamat' => 'mojokerto',
            'status' => 0,
            'komisi' => 0,
        ]);
    }
}

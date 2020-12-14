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
            'name' => 'Almi',            
            'email' => 'almi@yahoo.com',            
            'password' => Hash::make('admin123'),            
            'role' => 'admin',
            'image' => 'default.jpg',            
            'phone' => '098789927',         
            'alamat' => 'mojokerto',         
            'status' => 0,         
        ]);
        User::create([
            'name' => 'luay',            
            'email' => 'luay@yahoo.com',            
            'password' => Hash::make('admin123'),            
            'role' => 'member', 
            'image' => 'default.jpg',            
            'phone' => '098789927',         
            'alamat' => 'mojokerto',         
            'status' => 0,                
        ]);
    }
}

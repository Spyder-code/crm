<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'nama' => 'SpyderCode',
            'alamat' => 'Kota Mojokerto',
            'phone' => '083857317946',
            'email' => 'spydercode01@gmail.com',
            'logo' => 'http://127.0.0.1:8000/storage/images/perusahaan/logo.png',
            'banner' => 'http://127.0.0.1:8000/storage/images/perusahaan/logo-banner.png'
        ]);
    }
}

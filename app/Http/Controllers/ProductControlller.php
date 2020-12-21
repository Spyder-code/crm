<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Image;
use App\Invoice;
use App\MemberTarget;
use App\Price;
use App\Product;
use App\Target;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductControlller extends Controller
{
    public function detailProduk($nama, Price $price, $referal)
    {
        // $price = Price::where('id',$price->id)->first();
        $user = User::where('kode',$referal)->first();
        $image = Image::all()->where('id_produk',$price->id_produk);
        $kode = $user->kode;
        return view('customer.detailProduk',compact('price','kode','image'));
    }

    public function penjualanProduk($nama, Product $produk, Price $price, $referal)
    {
        $member = User::where('kode',$referal)->first();
        return view('customer.penjualanProduk',compact('produk','price','member'));
    }

    public function pembelian(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'sapaan' => 'required',
            'panggilan' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'alamat' => 'required',
        ]);

        $pembeli = Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'sapaan' => $request->sapaan,
            'panggilan' => $request->panggilan,
            'phone' => $request->phone,
            'status' => 0,
        ]);

        $invoice = Invoice::create([
            'id_pembeli' => $pembeli->id,
            'id_produk' => $request->id_produk,
            'id_member' => $request->id_member,
            'id_harga' => $request->id_harga,
            'jumlah' => $request->jumlah,
            'ongkir' => 0,
            'total' => $request->total,
            'status' => 0,
            'kode' => '0',
        ]);

        $kode = $invoice->id_pembeli.''.$invoice->id_member.''.$invoice->id_harga.''.$invoice->id;

        $url = 'https://api.callmebot.com/whatsapp.php?phone=+6283857317946&text=Order+baru+'.url('/invoice/'.$kode.'.'.$invoice->id).'&apikey=649619';
        $client = new Client();
        $response = $client->request('GET',$url);

        $json=[
            "token"=>"cd26aa51eacf67df3ea08030a72f0fcb",
            "source"=>6283857317946,
            "destination"=>$request->phone,
            "type"=>"text",
            "body"=>[
                "text"=>"Terima kasih telah melakukan transaksi.
                Untuk proses selanjutnya silahkan melakukan pembayaran dengan pilih opsi dibawah ini:

                1. TF BCA      : 7656756756 a.n spydercode
                2. TF GoPay  : 7878676767 a.n spydercode
                3. Pembayaran langsung pada alamat di bawah

                Salam kami!
                jl. kh usman mojokerto 61328

                ".url('/invoice/'.$kode.'.'.$invoice->id)
            ]
        ];
        $client = new Client();
        $response = $client->request('POST','http://waping.es/api/send',
        ['headers'=>['Content-Type'=>'application/json'],'json'=>$json]);

        Invoice::find($invoice->id)->update([
            'kode' => $kode
        ]);

        return redirect('/invoice/'.$kode.'.'.$invoice->id)->with('success','s');
    }
}

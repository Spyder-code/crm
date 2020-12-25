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

        $str = substr($request->phone,0,1);
        if($str=='0'){
            $phone = substr_replace($request->phone,'62',0,1);
        }else{
            $str = substr($request->phone,0,2);
            if ($str!='62') {
                return back()->with('danger','Harap masukan No.telp anda dengan benar!');
            } else {
                $phone = $request->phone;
            }
        }

        $pembeli = Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'sapaan' => $request->sapaan,
            'panggilan' => $request->panggilan,
            'phone' => $phone,
            'status' => 0,
        ]);

        $produk =Product::find($request->id_produk);
        $produk->update([
            'stock' => $produk->stock - $request->jumlah
        ]);
        $uangstr = str_replace('.','',$request->total);
        $uang = (int)$uangstr;
        $invoice = Invoice::create([
            'id_pembeli' => $pembeli->id,
            'id_produk' => $request->id_produk,
            'id_member' => $request->id_member,
            'id_harga' => $request->id_harga,
            'jumlah' => $request->jumlah,
            'ongkir' => 0,
            'total' => $uang,
            'status' => 0,
            'kode' => '0',
        ]);

        $kode = $invoice->id_pembeli.''.$invoice->id_member.''.$invoice->id_harga.''.$invoice->id;
        Invoice::find($invoice->id)->update([
            'kode' => $kode
        ]);

        $url = 'https://api.callmebot.com/whatsapp.php?phone=+6283857317946&text=Order+baru+'.url('/invoice/'.$kode.'.'.$invoice->id).'&apikey=649619';
        $client = new Client();
        $response = $client->request('GET',$url);

        $my_apikey = "OB705427TS8X23S05W05";
        $destination = $pembeli->phone;
        $message =
"Hai ".$pembeli->sapaan." ".$pembeli->panggilan.".

Pasti udah ga sabar nunggu barangnya datang kan?

Segera lakukan pembayaran supaya kami bisa segera memproses pesanan Anda

Cara bayar di ATM/internet banking Bank BRI:
    - klik menu transaksi lain
    - pilih transfer
    - BRI
    - Kode bank BRI (002)
    - masukkan nomor rekening tujuan : *370801021829539*
    - masukkan nominal pembayaran *sesuai tagihan*
    - pastikan nama pembayaran : *KHABIB ABDULLOH*
    - lanjutkan sampai selesai

Cara bayar di ATM lain (selain bank BRI)
    - klik menu tranfer ke bank BRI (002)
    - masukkan nomor rekening *370801021829539*
    - masukkan nominal pembayaran *sesuai tagihan*
    - pastikan nama pembayaran : *KHABIB ABDULLOH*
    - lanjutkan sampai selesai

Kirim bukti pembayaran kepada admin, dan mohon simpan bukti pembayaran.

Cek status pembayaran Anda pada link berikut
".url('/invoice/'.$kode.'.'.$invoice->id)."

setelah Anda melakukan pembayaran, pastikan status berubah menjadi 'paid' pada pojok kanan atas.

Jika status belum berubah dalam 1x24 jam, maka segera laporkan ke *WA*
*Official garasiart*

Salam

Team garasiart";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));


        return redirect('/invoice/'.$kode.'.'.$invoice->id)->with('success','s');
    }
}

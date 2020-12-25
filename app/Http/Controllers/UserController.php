<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Image;
use App\Invoice;
use App\Referal;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image as imageCon;
class UserController extends Controller
{
    public function index($kode)
    {
        $data = User::where('kode',$kode)->first();
        if ($data!=null) {
            return view('customer.daftar',compact('kode'));
        } else {
            abort(404);
        }

    }

    public function password($kode)
    {
        $data = User::where('kode',$kode)->first();
        if ($data!=null) {
            return view('customer.password', compact('data'));
        } else {
            abort(404);
        }
    }

    public function changePassword(Request $request, User $user)
    {
        $request->validate([
            'password' =>'required|confirmed|min:8'
        ]);

        User::find($user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/');
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'panggilan' => 'required',
            'desa' => 'required|max:38',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required|email|unique:users',
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

        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;
        $kelurahan = $request->kelurahan;
        $desa = ucfirst($request->desa);
        $alamat = $desa.' kelurahan '. $kelurahan.' kecamatan '.$kecamatan.' '.$kota.' provinsi '.$provinsi;

            $inisial = substr($request->panggilan,0,2);
            $panggilan = strtoupper($inisial);
            $tgl = date('d',strtotime($request->tanggal_lahir));

            $data = new User;
            $data->name = ucwords($request->nama);
            $data->sapaan = $request->sapaan;
            $data->panggilan = ucfirst($request->panggilan);
            $data->alamat = $desa;
            $data->alamat_lengkap = $alamat;
            $data->phone = $phone;
            $data->jenis_kelamin = $request->jenis_kelamin;
            $data->tanggal_lahir = $request->tanggal_lahir;
            $data->email = $request->email;
            $data->status = 0;
            $data->komisi = 10;
            $data->pendapatan = 0;
            $data->role = 'member';
            $data->password = Hash::make('member123');
            $data->image = asset('storage/images/user/default.jpg');
            $data->kode = $panggilan.$tgl.$data->getNextId();
            $data->save();

            $user = User::where('kode',$request->kode)->first();
            Referal::create([
                'member_id' => $user->id,
                'referal_id' => $data->id,
                'status' => 0,
            ]);

            $url = url('/card/'.$data->id);
            $params = http_build_query(array(
                "access_key" => "4703929de7f24e71ae525d1dda7955d6",
                "url" => $url,
            ));

            $image_data = file_get_contents("https://api.apiflash.com/v1/urltoimage?" . $params);
            file_put_contents(public_path('card.jpg'), $image_data);
            $img = imageCon::make(public_path('card.jpg'))->resize(1050,600)->save(public_path('card/'.$data->id.'.jpg'));

            $my_apikey = "OB705427TS8X23S05W05";
            $destination = $data->phone;
            $message =
"Hai ".$data->sapaan." ".$data->panggilan.".

Selamat Anda telah terdaftar menjadi member *GarasiArt*

*Berikut benefit menjadi member kami :*
    - Komis 10% setiap penjualan produk GarasiArt
    - 10% komisi tambahan jika 'aktif' (memenuhi target penjualan) setiap satu produk GarasiArt
    - Bisa mereferensikan pada teman untuk ikut menjadi member, dan dapatkan 10% komisi tambahan atas 'aktif' nya referal Anda
    - Berpotensi mendapat 100% komisi (up to Rp 10.000.000)
    - Bisa buka cabang GarasiArt
    - Untuk yang sudah punya bisnis sendiri, bisa berpartner dengan GarasiArt dan/atau Garasipalet
    - Untuk yang belum punya bisnis, akan kami ajarkan supaya punya bisnis sendiri
    - Sharing santai setiap bulan (problem solve)
    - Dibimbing sampai menghasilkan
    - Dibimbing sampai punya bisnis sendiri
    - dan masih banyak lagi.

Kita akan saling berbagi pengalaman dari berbagai pengalaman semua member GarasiArt mengenai dunia bisnis

Menemukan masalah dan memberikan solusi dengan berdiskusi

Manfaatkan semua benefit dari kami semaksimal mungkin ya ".$data->sapaan." ".$data->panggilan.".

*Selamat bergabung*

Terimakasih

Salam hebat

Khabib abdulloh";
            $api_url = "http://panel.rapiwha.com/send_message.php";
            $api_url .= "?apikey=". urlencode ($my_apikey);
            $api_url .= "&number=". urlencode ($destination);
            $api_url .= "&text=". urlencode ($message);
            $my_result_object = json_decode(file_get_contents($api_url, false));

            return redirect('/password/'.$data->kode);
    }

    public function invoice($kode, Invoice $invoice)
    {
        if ($kode==$invoice->kode) {
            return view('customer.invoice',compact('invoice'));
        }else{
            abort(404);
        }
    }

    public function card(User $user)
    {
        return view('member.card',compact('user'));
    }
}

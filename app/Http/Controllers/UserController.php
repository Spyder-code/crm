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
use Image as ImageCard;
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
            'desa' => 'required',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;
        $kelurahan = $request->kelurahan;
        $desa = $request->desa;
        $alamat = $desa.' kelurahan '. $kelurahan.' kecamatan '.$kecamatan.' '.$kota.' provinsi '.$provinsi;

        $cek = Customer::where('nama','LIKE','%'.$request->nama.'%')->first();

        if ($cek!=null) {
            $inisial = substr($request->panggilan,0,2);
            $panggilan = strtoupper($inisial);
            $tgl = date('d',strtotime($request->tanggal_lahir));

            $data = new User;
            $data->name = $request->nama;
            $data->panggilan = $request->panggilan;
            $data->alamat = $alamat;
            $data->phone = $request->phone;
            $data->jenis_kelamin = $request->jenis_kelamin;
            $data->tanggal_lahir = $request->tanggal_lahir;
            $data->email = $request->email;
            $data->status = 0;
            $data->komisi = 0;
            $data->role = 'member';
            $data->password = Hash::make('member123');
            $data->image = 'default.jpg';
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
            file_put_contents(public_path('card/'.$data->id.'.jpg'), $image_data);

            return redirect('/password/'.$data->kode);
        } else {
            return back()->with('danger','Mohon maaf anda tidak dapat menjadi member karena belum melakukan pembelian produk kami! ');
        }
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

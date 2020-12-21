<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\Invoice;
use App\MemberTarget;
use App\Price;
use App\Product;
use App\Referal;
use App\Target;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()&&Auth::user()->role=='admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('member.dashboard');
        }
    }

    public function mainAdmin()
    {
        $tmember = User::all()->where('role','member')->count();
        $tpendapatan = Invoice::all()->where('status',1)->sum('total');
        $tpembeli = Customer::all()->count();
        $tproduk = Product::all()->count();
        $data = Invoice::all()->where('status',0);
        return view('admin.dashboard',compact('tmember','tpendapatan','tpembeli','tproduk','data'));
    }

    public function mainMember()
    {
        $tproduk = Product::all()->count();
        $referal = Referal::all()->where('member_id',Auth::id())->count();
        $transaksi = Invoice::all()->where('status',1)->where('id_member',Auth::id())->count();
        $data = Invoice::all()->where('status',0)->where('id_member',Auth::id());
        return view('member.dashboard',compact('referal','transaksi','tproduk','data'));
    }

    public function profileMember()
    {
        return view('member.profile');
    }

    public function referral()
    {
        $data = User::all();
        $referal =Referal::all()->count();
        return view('admin.referral',compact('data','referal'));
    }

    public function referralMember()
    {
        $data = Referal::all()->where('member_id',Auth::id());
        $referal = $data->count();
        return view('member.referral',compact('data','referal'));
    }

    public function referralDetail(User $member)
    {
        $data = Referal::all()->where('member_id',$member->id);
        $jumlah = $data->count();
        return view('admin.detailReferral',compact('data','member','jumlah'));
    }

    public function promosi()
    {
        $id = Auth::id();
        $produk = Product::all();
        $target = Target::all();
        $memberTarget = array();
        foreach ($target as $item ) {
            $total = MemberTarget::all()->where('id_member',$id)->where('id_target',$item->id)->count();
            array_push($memberTarget,$total);
        }
        return view('admin.promosi',compact('produk','target','memberTarget'));
    }

    public function promosiPenjualan(Product $produk)
    {
        $harga = Price::all()->where('id_produk',$produk->id);
        return view('admin.promosiPenjualan',compact('produk','harga'));
    }

    public function activity()
    {
        return view('admin.activity');
    }

    public function customer()
    {
        $data = Customer::all();
        $member = User::all()->where('role','member')->count();
        return view('admin.customer',compact('data','member'));
    }

    public function detailCustomer(Customer $customer)
    {
        return view('admin.detailCustomer',compact('customer'));
    }

    public function destroyCustomer(Customer $customer)
    {
        Customer::destroy($customer->id);
        return back()->with('success','Data berhasil dihapus!');
    }

    public function destroyTarget(Target $target)
    {
        Target::destroy($target->id);
        return back()->with('success','Data berhasil dihapus!');
    }

    public function updateTarget(Request $request,Target $target)
    {
        Target::find($target->id)->update([
            'id_produk' => $request->id_produk,
            'jumlah' => $request->jumlah,
        ]);
        return back()->with('success','Data berhasil diubah!');
    }

    public function profile()
    {
        $perusahaan = Company::first();
        return view('admin.profile',compact('perusahaan'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'confirmed',
            'image3' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if($request->image3!=null){
            if ($files = $request->file('image3')) {
                $profileImage =Auth::user()->id.'.'.$files->getClientOriginalExtension();
                $path = $files->storeAs('public/images/user', $profileImage);
                $url = Storage::url($path);
                $imgUrl = url($url);
                User::find(Auth::user()->id)->update([
                    'image' => $imgUrl
                ]);
            }
        }

        if ($request->password!=null) {
            User::find(Auth::user()->id)->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
        }
        User::find(Auth::user()->id)->update([
            'name' => $request->name,
        ]);

        return back()->with('success','Profil akun berhasil diubah!');
    }

    public function updatePerusahaan(Request $request, Company $perusahaan)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'image1' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        Company::find($perusahaan->id)->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if($request->image1!=null){
            if ($files = $request->file('image1')) {
                $profileImage ='logo.'.$files->getClientOriginalExtension();
                $path = $files->storeAs('public/images/perusahaan', $profileImage);
                $url = Storage::url($path);
                $imgUrl = url($url);
                Company::find($perusahaan->id)->update([
                    'logo' => $imgUrl
                ]);
            }
        }
        if($request->image2!=null){
            if ($files = $request->file('image2')) {
                $profileImage ='logo-banner.'.$files->getClientOriginalExtension();
                $path = $files->storeAs('public/images/perusahaan', $profileImage);
                $url = Storage::url($path);
                $imgUrl = url($url);
                Company::find($perusahaan->id)->update([
                    'banner' => $imgUrl
                ]);
            }
        }

        return back()->with('success','Profil perusahaan berhasil diubah!');
    }

    // Member

    public function transaksi()
    {
        $id = Auth::id();
        $target = Target::all();
        $memberTarget = array();
        foreach ($target as $item ) {
            $total = MemberTarget::all()->where('id_member',$id)->where('id_target',$item->id)->count();
            array_push($memberTarget,$total);
        }
        $data = Invoice::all()->where('id_member',Auth::user()->id);
        return view('member.transaksi',compact('data','target','memberTarget'));
    }

    public function transaksiDetail(Invoice $invoice)
    {
        return view('admin.invoice.show',compact('invoice'));
    }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\MemberTarget;
use App\Referal;
use App\Target;
use App\User;
use App\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all()->where('role','member')->sortByDesc('created_at');
        $aktif =  User::all()->where('role','member')->where('status',1);
        return view('admin.member.index',compact('data','aktif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'panggilan' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'email' => 'required|email|unique:users',
        ]);

        $inisial = substr($request->panggilan,0,2);
        $panggilan = strtoupper($inisial);
        $tgl = date('d',strtotime($request->tanggal_lahir));

        $data = new User;
        $data->name = $request->nama;
        $data->panggilan = $request->panggilan;
        $data->alamat = $request->alamat;
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

        Referal::create([
            'member_id' => 1,
            'referal_id' => $data->id,
            'status' => 0,
        ]);

        return back()->with('success','Member berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $member)
    {
        $target = Target::all();
        $memberTarget = array();
        foreach ($target as $item ) {
            $total = MemberTarget::all()->where('id_member',$member->id)->where('id_target',$item->id)->count();
            array_push($memberTarget,$total);
        }
        $transaksi = Invoice::all()->where('id_member',$member->id);
        return view('admin.member.show',compact('member','transaksi','target','memberTarget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $member)
    {
        return view('admin.member.edit',compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $member)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'phone' => 'required',
        ]);

        User::find($member->id)->update([
            'name' => $request->nama,
            'alamat' => $request->alamat,
            'phone' => $request->phone,
        ]);

        return back()->with('success','Data berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member)
    {
        User::destroy($member->id);
        return back()->with('success','Member '.$member->name.' berhasil dihapus!');
    }

    public function resetPassword(Request $request)
    {
        User::find($request->id)->update([
            'password' => Hash::make('member123')
        ]);
        return back()->with('success','Reset Password berhasil!');
    }

    public function resetPendapatan(Request $request, User $member)
    {
        User::find($member->id)->update([
            'pendapatan' => 0
        ]);

        Withdraw::create([
            'id_member' => $member->id,
            'jumlah' => $request->pendapatan
        ]);
        return redirect()->route('withdraw.index')->with('success','Pendapatan member '.$member->nama.' berhasil diambil!');
    }
}

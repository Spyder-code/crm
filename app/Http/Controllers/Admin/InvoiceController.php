<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\MemberTarget;
use App\Product;
use App\Referal;
use App\Target;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invoice::all()->sortByDesc('created_at');
        $pendapatan = Invoice::all()->where('status',1)->sum('total');
        $admin = Invoice::all()->where('id_member',1)->count();
        $member = Invoice::all()->where('id_member','!=',1)->count();
        return view('admin.invoice.index',compact('data','admin','member','pendapatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Product::all()->where('status',0);
        $target = Target::all()->sortByDesc('updated_at');
        return view('admin.invoice.create',compact('data','target'));
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
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        Target::create([
            'id_produk' => $request->id_produk,
            'jumlah' => $request->jumlah,
        ]);

        Product::find($request->id_produk)->update([
            'status' =>1
        ]);

        return back()->with('success','Target berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('admin.invoice.show',compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        Invoice::find($invoice->id)->update([
            'status' => 1
        ]);

        $member = User::find($invoice->id_member);
        $referal = Referal::where('referal_id',$invoice->id_member)->first();

        $data = Target::all();
        foreach ($data as $item) {
            if ($item->id_produk==$invoice->id_produk) {
                MemberTarget::create([
                    'id_target' => $item->id,
                    'id_member' => $invoice->id_member,
                ]);
            }
        }
        $target = Target::all();
        $memberTarget = array();
        foreach ($target as $item ) {
            $total = MemberTarget::all()->where('id_member',$invoice->id_member)->where('id_target',$item->id)->count();
            if($item->jumlah==$total){
                User::find($invoice->id_member)->update([
                    'komisi' => $member->komisi + 10
                ]);
                User::find($referal->member_id)->update([
                    'komisi' => $member->komisi + 10
                ]);
            }
            array_push($memberTarget,$total);
        }

        $my_apikey = "OB705427TS8X23S05W05";
        $destination = $invoice->pembeli->phone;
        $message =
"Yey..!
Pesanan ".$invoice->pembeli->sapaan." ".$invoice->pembeli->panggilan." sudah dibayar.

Pesanan akan kami proses dan secepatnya akan kami kirim
Tunggu barangnya sampai ya ".$invoice->pembeli->sapaan."

Cek status pembayaran pada link berikut:
".url('invoice/'.$invoice->kode.'.'.$invoice->id)."

Terimakasih atas kepercayaannya pada
*Garasiart*

Semoga bahagia selalu ".$invoice->pembeli->sapaan." ".$invoice->pembeli->panggilan."

Salam

Team garasiart";
        $api_url = "http://panel.rapiwha.com/send_message.php";
        $api_url .= "?apikey=". urlencode ($my_apikey);
        $api_url .= "&number=". urlencode ($destination);
        $api_url .= "&text=". urlencode ($message);
        $my_result_object = json_decode(file_get_contents($api_url, false));

        return back()->with('success','Status pembayaran berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        Invoice::destroy($invoice->id);
        return back()->with('success','Transaksi berhasil dihapus!');
    }
}

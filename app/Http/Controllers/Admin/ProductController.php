<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Image;
use App\Invoice;
use App\Price;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::all()->sortByDesc('created_at');
        $terjual = Invoice::all()->sum('jumlah');
        $stok = Product::all()->sum('stock') - $terjual;
        return view('admin.produk.index',compact('data','terjual','stok'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.produk.create');
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
            'nama' => 'required|string',
            'stok' => 'required|numeric',
            'berat' => 'required|numeric',
            'deskripsi' => 'required',
            'harga1' => 'required|numeric',
            'harga2' => 'required|numeric',
            'harga3' => 'required|numeric',
            'harga3' => 'required|numeric',
            'harga4' => 'required|numeric',
            'image1' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $nama = str_replace(' ','-',$request->nama);
        $link = url('produk/').'/'.$nama;

        $produk = Product::create([
            'nama' => $request->nama,
            'stock' => $request->stok,
            'berat' => $request->berat,
            'deskripsi' => $request->deskripsi,
            'status' => 0,
            'link' => $link
        ]);

        Price::create([
            'id_produk' => $produk->id,
            'harga' => $request->harga1,
            'area' => '0-50km',
        ]);
        Price::create([
            'id_produk' => $produk->id,
            'harga' => $request->harga2,
            'area' => '51-100km',
        ]);
        Price::create([
            'id_produk' => $produk->id,
            'harga' => $request->harga3,
            'area' => '101-200km',
        ]);
        Price::create([
            'id_produk' => $produk->id,
            'harga' => $request->harga4,
            'area' => '>200km',
        ]);

        for ($i=1; $i<=4; $i++) {
            if($request->image.$i!=null){
                if ($files = $request->file('image'.$i)) {
                    $profileImage =$produk->id.'-'.$i.'.'.$files->getClientOriginalExtension();
                    $path = $files->storeAs('public/images/produk', $profileImage);
                    $url = Storage::url($path);
                    $imgUrl = url($url);
                    Image::create([
                        'id_produk' => $produk->id,
                        'name' =>  $profileImage,
                        'path' =>  $imgUrl,
                        'order' =>  $i,
                    ]);
                    if ($i==1) {
                        Product::find($produk->id)->update([
                            'image' => $imgUrl
                        ]);
                    }
                }
            }
        }

        return back()->with('success','Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $produk)
    {
        $harga = Price::all()->where('id_produk',$produk->id);
        $image = Image::all()->where('id_produk',$produk->id);
        $pic = $image->first();
        return view('admin.produk.show',compact('produk','harga','image','pic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $produk)
    {
        $harga = Price::all()->where('id_produk',$produk->id);
        $image = Image::all()->where('id_produk',$produk->id);
        return view('admin.produk.edit',compact('produk','harga','image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'nama' => 'required',
            'stok' => 'required|numeric',
            'berat' => 'required|numeric',
            'deskripsi' => 'required',
            'harga1' => 'required|numeric',
            'harga2' => 'required|numeric',
            'harga3' => 'required|numeric',
            'harga3' => 'required|numeric',
            'harga4' => 'required|numeric',
            'image1' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image2' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image3' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
            'image4' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        Product::find($produk->id)->update([
            'nama' => $request->nama,
            'stock' => $request->stok,
            'berat' => $request->berat,
            'deskripsi' => $request->deskripsi,
            'status' => 0
        ]);

        Price::find($request->idHarga1)->update([
            'harga' => $request->harga1,
        ]);
        Price::find($request->idHarga2)->update([
            'harga' => $request->harga2,
        ]);
        Price::find($request->idHarga3)->update([
            'harga' => $request->harga3,
        ]);
        Price::find($request->idHarga4)->update([
            'harga' => $request->harga4,
        ]);

        for ($i=1; $i<=4; $i++) {
            if($request->image.$i!=null){
                if ($files = $request->file('image'.$i)) {
                    $profileImage = $produk->id.'-'.$i.'.'.$files->getClientOriginalExtension();
                    $path = $files->storeAs('public/images/produk', $profileImage);
                    $url = Storage::url($path);
                    $imgUrl = url($url);
                    $img = Image::find($request->idImage.$i);
                    if ($img!=null) {
                        $img->update([
                            'name' =>  $profileImage,
                            'path' =>  $imgUrl,
                            'order' =>  $i,
                        ]);
                    }
                    if ($i==1) {
                        Product::find($produk->id)->update([
                            'image' => $imgUrl
                        ]);
                    }
                }
            }
        }

        return back()->with('success','Produk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $produk)
    {
        Product::destroy($produk->id);
        return back()->with('success','Produk berhasil dihapus!');
    }
}

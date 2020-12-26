@extends('layouts.user')
@section('image',{{ $price->produk->image }})
@section('title',{{ $price->produk->nama }})
@section('deskripsi',{{ $price->produk->deskripsi }})
@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <img src="{{ $price->produk->image }}" id="target" style="max-height: 450px;min-height:200px; width:100%" alt="{{ $price->produk->nama }}" class="img-fluid">
                        <div class="row mt-2">
                            @foreach ($image as $item)
                            <div class="col">
                                <div class="d-flex justify-content-center align-items-center text-center">
                                    <img src="{{ $item->path }}" class="img img-thumbnail" style="width:80px; height: 80px;" alt="{{ $item->name }}">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <hr>
                    </div>
                    <div class="col-sm">
                        <h1 class="text-dark">{{ $price->produk->nama }}</h1>
                        <hr>
                        <p>{{ $price->produk->deskripsi }}</p>
                        <hr>
                        <div class="d-flex">
                            <h2 class="text-dark mr-2">Harga </h2>
                        </div>
                        <hr>
                        <p class="text-success">Rp. <span class="uang">{{ $price->harga }}</span></p>
                        <a href="{{ url('produk/'.str_replace(' ','-',$price->produk->nama).'.'.$price->id_produk.'/'.$price->id.'/'.$kode) }}" class="btn btn-success w-100"><i class="fas fa-shopping-cart"></i> Beli sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('.img').click(function (e) {
            e.preventDefault();
            var src = $(this).attr('src');
            $('#target').attr('src',src);
        });
        $('.uang').mask('000.000.000.000.000', {reverse: true});
    </script>
@endsection

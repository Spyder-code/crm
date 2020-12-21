@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-header bg-info text-white">Info produk</div>
                    <div class="card-body">
                        <ul class="list-group text-left">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col col-4">
                                        <label for="address">Nama produk</label>
                                    </div>
                                    <div class="col col-2">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col">
                                        {{$produk->nama}}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col col-4">
                                        <label for="address">Deskripsi</label>
                                    </div>
                                    <div class="col col-2">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col">
                                        {{$produk->deskripsi}}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col col-4">
                                        <label for="address">Stock</label>
                                    </div>
                                    <div class="col col-2">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col">
                                        {{$produk->stock}}
                                    </div>
                                </div>
                            </li>
                            @foreach ($harga as $item)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col col-4">
                                        <label for="address">Harga {{ $item->area }}</label>
                                    </div>
                                    <div class="col col-2">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col">
                                        Rp. <span class="uang">{{$item->harga}}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header bg-warning text-white">Image</div>
                    <div class="card-body text-center">
                        <img src="{{ $pic->path }}" id="target" alt="{{ $pic->name }}" class="img-thumbnail" style="height: 300px">
                        <hr>
                        <div class="row mt-2">
                            @foreach ($image as $item)
                            <div class="col-md-3">
                                <img src="{{ $item->path }}" class="img" style="width:100px; height: 80px;" alt="{{ $item->name }}">
                            </div>
                            @endforeach
                        </div>
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

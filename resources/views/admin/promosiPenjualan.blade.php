@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">Buat link penjualan</div>
                    <div class="card-body text-center">
                        <img src="{{ $produk->image }}" alt="{{ $produk->name }}" class="img-thumbnail" style="height: 300px">
                        <hr>
                        <form id="form">
                            <input type="hidden" id="url" value="{{ $produk->link }}">
                            <input type="hidden" id="id_produk" value="{{ $produk->id }}">
                            <input type="hidden" id="kode" value="{{ Auth::user()->kode }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama" value="{{ $produk->nama }}" readonly>
                                <hr>
                                <label>Pilih Area Penjualan</label>
                                <div class="form-group">
                                    <div class="customize-input border border-info">
                                        <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius" id="harga">
                                            <option selected></option>
                                            @foreach ($harga as $item)
                                            <option value="{{ $item->id }}"> {{ $item->area }}  (Rp.{{ $item->harga }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mt-4" id="result">
                                    <input type="text" id="link" class="form-control" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" data-clipboard-target="#link" type="button"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div class="card">
                    <div class="card-header bg-info text-white">Buat link promosi</div>
                    <div class="card-body text-center">
                        <img src="{{ $produk->image }}" alt="{{ $produk->name }}" class="img-thumbnail" style="height: 300px">
                        <hr>
                        <form>
                            <input type="hidden" id="url1" value="{{ $produk->link }}">
                            <input type="hidden" id="kode1" value="{{ Auth::user()->kode }}">
                            <div class="form-group">
                                <input type="text" class="form-control" id="nama1" value="{{ $produk->nama }}" readonly>
                                <hr>
                                <label>Pilih Area Penjualan</label>
                                <div class="form-group">
                                    <div class="customize-input border border-info">
                                        <select class="custom-select custom-select-set form-control bg-white border-0 custom-shadow custom-radius" id="harga1">
                                            <option selected></option>
                                            @foreach ($harga as $item)
                                            <option value="{{ $item->id }}"> {{ $item->area }}  Rp.<span class="uang">{{ $item->harga }}</span></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="input-group mt-4" id="result1">
                                    <input type="text" id="link1" class="form-control" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" data-clipboard-target="#link1" type="button"><i class="fas fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm">
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
                                        Rp. {{$item->harga}}
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <script>
        new ClipboardJS('.btn');
        var url = $('#url').val();
        var ref = $('#kode').val();
        var id_produk = $('#id_produk').val();
        $('#result').hide();
        $('#harga').change(function (e) {
            var val = $(this).val();
            $('#link').val(url+'.'+id_produk+'/'+val+'/'+ref);
            $('#result').show();
        });
        var url1 = $('#url1').val();
        var ref1 = $('#kode1').val();
        $('#result1').hide();
        $('#harga1').change(function (e) {
            var val = $(this).val();
            $('#link1').val(url1+'.'+val+'/'+ref1);
            $('#result1').show();
        });
        $('.uang').mask('000.000.000.000.000', {reverse: true});
    </script>
@endsection

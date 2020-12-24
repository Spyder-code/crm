@extends('layouts.user')
@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        <h2 class="mr-3">{{ $produk->nama }}</h2>
                        <hr>
                        <a href="{{ $produk->image }}" target="d-blank">
                            <img src="{{ $produk->image }}" alt="{{ $produk->nama }}" class="img-thumbnail">
                        </a>
                        <h3 class="text-success mt-3">Rp. <span class="uang">{{ $price->harga }}</span></h3>
                        <hr>
                        <p>{{ $produk->deskripsi }}</p>
                    </div>
                    <div class="col-sm">
                        <h2>Data Produk </h2>
                        <hr>
                        <form action="{{ route('user.pembelian') }}" method="post">
                            <input type="hidden" name="id_harga" value="{{ $price->id }}">
                            <input type="hidden" name="id_produk" value="{{ $price->id_produk }}">
                            <input type="hidden" name="id_member" value="{{ $member->id }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-8">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" value="{{ $produk->nama }}" readonly>
                                </div>
                                <div class="col">
                                    <label>Berat/Kg</label>
                                    <input type="text" class="form-control" value="{{ $produk->berat }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label>Jumlah Pembelian</label>
                                    <input id="jumlah" type="number" name="jumlah" class="form-control" min="1" value="1" max="{{ $produk->stock }}">
                                </div>
                                <div class="col">
                                    <label>Harga</label>
                                    <input type="text" id="harga" class="form-control uang" value="{{ $price->harga }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Total Harga</label>
                                <input id="total" type="text" name="total" class="form-control uang" value="{{ $price->harga }}" readonly>
                            </div>
                            <h2>Data Pembeli</h2>
                            <hr>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <div class="form-group row">
                                <div class="col">
                                    <label>Sapaan</label>
                                    <select name="sapaan" class="form-control">
                                        <option value="Pak">Pak</option>
                                        <option value="Bu">Bu</option>
                                        <option value="Mas">Mas</option>
                                        <option value="Mbak">Mbak</option>
                                        <option selected value="Kak">Kak</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Nama Panggilan</label>
                                    <input type="text" name="panggilan" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>No. Telp (WA)</label>
                                <input type="number" name="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <button class="btn btn-success w-100 mt-3" onclick="return confirm('Are you sure?')">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#jumlah').change(function (e) {
            var val = $(this).val();
            var harga = $('#harga').val();
            var total = val * harga;
            $('#total').val(total);
        });
        $('.uang').mask('000.000.000.000.000', {reverse: true});
    </script>
@endsection

@extends('layouts.user')
@section('deskripsi')
Mau dapat hadiah produk Garasiart setiap ulang tahun? Mau juga dapat bagi hasil 100% tanpa potongan biaya apapun? Segera daftar, dan login untuk nikmati benefitnya
@endsection
@section('image',{{ asset('images/logo.jpg') }})
@section('title','Daftar member | Garasiart')
@section('content')
    @if ($message = Session::get('danger'))
    <div class="row">
        <div class="col mt-3">
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>{{ $message }}</strong>
            </div>
        </div>
    </div>
    @endif
    <div class="container">
        <div class="card shadow-lg border border-primary">
            <div class="card-body">
                <h1>Pendaftaran Member</h1>
                <hr>
                <form action="{{ route('user.daftar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kode" value="{{ $kode }}">
                    <input type="hidden" id="1" name="provinsi">
                    <input type="hidden" id="2" name="kota">
                    <input type="hidden" id="3" name="kecamatan">
                    <input type="hidden" id="4" name="kelurahan">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
                            <input type="text" name="panggilan" class="form-control @error('panggilan') is-invalid @enderror" value="{{ old('panggilan') }}">
                            @error('panggilan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <label>No. Telp</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="LK" selected>Laki-laki</option>
                                <option value="PR">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Rumah</label>
                        <input type="text" name="desa" class="form-control @error('desa') is-invalid @enderror" value="{{ old('desa') }}">
                        @error('desa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label>Provinsi</label>
                            <select id="provinsi" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Kabupaten/Kota</label>
                            <select id="kota" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label>Kecamatan</label>
                            <select id="kecamatan" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col">
                            <label>Kelurahan</label>
                            <select id="kelurahan" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="alamat">
                    <button type="submit" class="btn btn-success d-block w-100">Tambah Member</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>

        function getProvinsi(){
            return fetch('https://dev.farizdotid.com/api/daerahindonesia/provinsi')
            .then(response => response.json())
            .then(data => data.provinsi)
        }

        function getKota(id){
            return fetch('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi='+id)
            .then(response => response.json())
            .then(data => data.kota_kabupaten)
        }

        function getKecamatan(id){
            return fetch('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota='+id)
            .then(response => response.json())
            .then(data => data.kecamatan)
        }

        function getKelurahan(id){
            return fetch('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan='+id)
            .then(response => response.json())
            .then(data => data.kelurahan)
        }

        async function start() {
            let provinsi = document.getElementById('provinsi').options;
            let kota = document.getElementById('kota').options;
            let kecamatan = document.getElementById('kecamatan').options;
            let kelurahan = document.getElementById('kelurahan').options;
            var data = await getProvinsi();
            data.forEach(option =>
            provinsi.add(
                new Option(option.nama, option.id)
            ));
            $('#provinsi').change(async function () {
                var id = $(this).val();
                var nama = $( "#provinsi option:selected" ).text();
                $('#1').val(nama);
                $('#kota').html('');
                var data = await getKota(id);
                data.forEach((option,idx) =>{
                    if (idx==0) {
                        kota.add(
                            new Option('', '',true)
                        )
                        kota.add(
                            new Option(option.nama,option.id)
                        )
                    } else {
                        kota.add(
                            new Option(option.nama, option.id)
                        )
                    }
                });
                $('#kota').change(async function () {
                    var id = $(this).val();
                    var nama = $( "#kota option:selected" ).text();
                    $('#2').val(nama);
                    $('#kecamatan').html('');
                    var data = await getKecamatan(id);
                    data.forEach((option,idx) =>{
                        if (idx==0) {
                        kecamatan.add(
                            new Option('', '',true)
                        )
                        kecamatan.add(
                            new Option(option.nama, option.id)
                        )
                    } else {
                        kecamatan.add(
                            new Option(option.nama, option.id)
                        )
                    }
                    });
                    $('#kecamatan').change(async function () {
                        var id = $(this).val();
                        var nama = $( "#kecamatan option:selected" ).text();
                        $('#3').val(nama);
                        $('#kelurahan').html('');
                        var data = await getKelurahan(id);
                        data.forEach((option,idx) =>{
                            if (idx==0) {
                            kelurahan.add(
                                new Option('', '',true)
                            )
                            kelurahan.add(
                                new Option(option.nama, option.id)
                            )
                        } else {
                            kelurahan.add(
                                new Option(option.nama, option.id)
                            )
                        }
                        });
                        $('#kelurahan').change(function () {
                            var nama = $( "#kelurahan option:selected" ).text();
                            $('#4').val(nama);
                        });
                    });
                });
            });
        }

        start();
    </script>
@endsection


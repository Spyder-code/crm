@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        @if ($message = Session::get('success'))
        <div class="row">
            <div class="col mt-3">
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong>{{ $message }}</strong>
                </div>
            </div>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        <div class="row">
            @if (Auth::user()->role=='admin')
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-info text-white">Profil Perusahaan</div>
                    <div class="card-body">
                        <form action="{{ route('admin.updatePerusahaan',['perusahaan'=>$perusahaan->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nama Perusahaan</label>
                                <input type="text" name="nama" value="{{ $perusahaan->nama }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" value="{{ $perusahaan->alamat }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ $perusahaan->email }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="phone" value="{{ $perusahaan->phone }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="text-center"><strong>Logo</strong></label>
                                <hr>
                                <label>Clik image to change</label><br>
                                <label for="image1" class="text-center" data-id="img1" class="text-center">
                                    <img src="{{$perusahaan->logo}}" id="img1" class="img-thumbnail" style="max-height:259px; min-height:90px">
                                </label>
                                <input type="file" name="image1" id="image1"  onchange="loadImg(event)" hidden>
                            </div>
                            <div class="form-group">
                                <label class="text-center"><strong>Banner</strong></label>
                                <hr>
                                <label>Clik image to change</label><br>
                                <label for="image2" class="text-center" data-id="img2">
                                    <img src="{{$perusahaan->banner}}" class="img-thumbnail" id="img2" style="max-height:259px; min-height:90px">
                                </label>
                                <input type="file" name="image2" id="image2"  onchange="loadImg(event)" hidden>
                            </div>
                            <button type="submit" class="btn btn-info d-block w-100">Update Perusahaan</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">Profil Akun</div>
                    <div class="card-body">
                        <form action="{{ Auth::user()->role=='admin'?route('admin.updateProfil'):route('member.updateProfil') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="alamat" value="{{ Auth::user()->email }}" readonly class="form-control">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                            <div class="form-group">
                                <label>Clik image to change</label>
                                <label for="image3" class="text-center" data-id="img3">
                                    <img src="{{Auth::user()->image}}" id="img3" class="img-thumbnail" id="img3" style="max-height:259px; min-height:90px">
                                </label>
                                <input type="file" name="image3" id="image3"  onchange="loadImg(event)" hidden>
                            </div>
                            <button type="submit" class="btn btn-success d-block w-100">Update Akun</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function loadImg (event){
        var id = event.target.labels[0].dataset.id;
        $('#'+id).attr('src', URL.createObjectURL(event.target.files[0]));
    };
</script>
@endsection

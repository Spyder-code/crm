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
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header bg-info text-white">Profil</div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>ID</label>
                                <input type="text" name="nama" value="{{ Auth::user()->kode }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Nama lengkap</label>
                                <input type="text" name="nama" value="{{ Auth::user()->name }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea  cols="30" rows="5" class="form-control" readonly>{{ Auth::user()->alamat }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" name="phone" value="{{ Auth::user()->phone }}" class="form-control" readonly>
                            </div>
                            {{-- <button type="submit" class="btn btn-info d-block w-100">Update Perusahaan</button> --}}
                        </form>
                    </div>
                </div>
            </div>
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

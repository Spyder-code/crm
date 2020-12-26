@extends('layouts.user')
@section('image',{{ asset('images/logo.jpg') }})
@section('title','Ganti password')
@section('deskripsi','ganti password member')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">Akun Member</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{ route('user.password',['user'=>$data->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $data->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="password" >{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <button class="btn btn-success w-100 mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

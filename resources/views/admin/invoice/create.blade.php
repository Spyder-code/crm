@extends('layouts.admin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Target Penjualan Member!</h3>
            </div>
            <div class="col-5 align-self-center">
                <div class="bg-white border-0 custom-shadow custom-radius float-right p-3">
                    {{ date('d F Y') }}
                </div>
            </div>
        </div>
    </div>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">Buat Target Penjualan</div>
                    <div class="card-body">
                        <form action="{{ route('invoice.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <select name="id_produk" class="form-control">
                                    <option value=""></option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Penjualan</label>
                                <input type="number" name="jumlah" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-outline-success d-block w-100">Buat Target</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">List target penjualan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th>Image</th>
                                        <th>Jumlah</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($target as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->produk->nama }}</td>
                                        <td class="text-center">
                                            <img src="{{ $item->produk->image }}" alt="{{ $item->produk->nama }}" style="height: 100px; width:100px">
                                        </td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td class="d-flex">
                                            <form action="{{ route('admin.target.destroy',['target'=>$item->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="bottom" title="Delete data" onclick="return confirm('Are you sure?')"><i class="text-white fas fa-trash-alt"></i></button>
                                            </form>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $item->id }}"><i class="text-white fas fa-pencil-alt"></i></button>
                                        </td>
                                    </tr>
                                    <div id="myModal{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('admin.target.update',['target' => $item->id]) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Ubah Target</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Produk</label>
                                                        <select name="id_produk" class="form-control">
                                                            @foreach ($data as $produk)
                                                                @if ($produk->id==$item->id)
                                                                    <option selected value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                                                @else
                                                                    <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah Penjualan</label>
                                                        <input type="number" name="jumlah" value="{{ $item->jumlah }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update target</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- CSS Here -->
<link href="{{ asset('admin/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
<!-- Javascript Here -->
<script src="{{ asset('admin/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('admin/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>
<script>
    $('#zero_config').DataTable();
</script>
@endsection


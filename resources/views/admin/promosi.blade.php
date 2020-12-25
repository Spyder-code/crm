@extends('layouts.admin')
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-7 align-self-center">
                <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Promosi Produk!</h3>
            </div>
            <div class="col-5 align-self-center">
                <div class="bg-white border-0 custom-shadow custom-radius float-right p-3">
                    {{ date('d F Y') }}
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card border border-warning">
                    <div class="card-header bg-warning text-white">Target</div>
                    <div class="card-body text-center">
                        <ul class="list-group">
                            @foreach ($target as $item)
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col col-4">
                                        <label for="address">{{ $item->produk->nama }}</label>
                                    </div>
                                    <div class="col col-2">
                                        <label for="">:</label>
                                    </div>
                                    <div class="col">
                                        @if ($memberTarget[$loop->index]==$item->jumlah)
                                            <div class="badge badge-success">Complete</div>
                                        @elseif ($memberTarget[$loop->index]>=$item->jumlah)
                                            <div class="badge badge-success">Complete</div>
                                        @else
                                        {{ $memberTarget[$loop->index] }}/{{ $item->jumlah }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card border border-success">
                    <div class="card-header bg-success text-white">Target Penjualan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($target as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->produk->nama }}</td>
                                        <td class="text-center"><img src="{{ $item->produk->image }}" alt="{{ $item->produk->nama }}" style="height: 100px; width:100px"></td>
                                        <td>
                                            <a href="{{ Auth::user()->role=='admin'?route('produk.show',['produk'=>$item->id_produk]):route('member.produk.detail',['produk'=>$item->id_produk]) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Detail produk"><i class="text-white fas fa-search"></i></a>
                                            <a href="{{ Auth::user()->role=='admin'?route('admin.promosi.penjualan',['produk'=>$item->id_produk]) : route('member.promosi.penjualan',['produk'=>$item->id_produk]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Buat link penjualan"><i class="fas fa-shopping-bag"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card border border-primary">
                    <div class="card-header bg-primary text-white">Daftar Semua Produk</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ substr($item->deskripsi,0,30) }}</td>
                                        <td class="text-center"><img src="{{ $item->image }}" alt="{{ $item->nama }}" style="height: 100px; width:100px"></td>
                                        <td>
                                            <a href="{{ Auth::user()->role=='admin'?route('produk.show',['produk'=>$item->id]):route('member.produk.detail',['produk'=>$item->id]) }}" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="Detail produk"><i class="text-white fas fa-search"></i></a>
                                            <a href="{{ Auth::user()->role=='admin'?route('admin.promosi.penjualan',['produk'=>$item->id]) : route('member.promosi.penjualan',['produk'=>$item->id]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Buat link penjualan"><i class="fas fa-shopping-bag"></i></a>
                                        </td>
                                    </tr>
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

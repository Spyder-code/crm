@extends('layouts.admin')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Selamat Datang {{ Auth::user()->name }}!</h3>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="alert alert-secondary">
                <strong>{{ date('d F Y') }}</strong>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- *************************************************************** -->
    <!-- Start First Cards -->
    <!-- *************************************************************** -->
    <div class="card-group">
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $tmember }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Semua Member</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                class="set-doller">Rp.</sup>{{ number_format($tpendapatan,2,',','.') }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Semua Pendapatan
                        </h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-right">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <div class="d-inline-flex align-items-center">
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $tpembeli }}</h2>
                        </div>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Semua Pembeli</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex d-lg-flex d-md-block align-items-center">
                    <div>
                        <h2 class="text-dark mb-1 font-weight-medium">{{ $tproduk }}</h2>
                        <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Semua Produk</h6>
                    </div>
                    <div class="ml-auto mt-md-3 mt-lg-0">
                        <span class="opacity-7 text-muted"><i data-feather="package"></i></span>
                    </div>
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
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header bg-primary text-white">Transaksi belum dikonfirmasi</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Member</th>
                                    <th>Nama Pembeli</th>
                                    <th>Produk</th>
                                    <th>Tanggal Pesanan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->member->name }}</td>
                                    <td>{{ $item->pembeli->nama }}</td>
                                    <td>{{ $item->produk->nama }}</td>
                                    <td>{{ date('d F Y H:i', strtotime($item->created_at)) }}</td>
                                    <td>
                                        @if ($item->status==0)
                                            <span class="badge badge-danger">Belum bayar</span>
                                        @elseif($item->status==1)
                                        <span class="badge badge-success">Lunas</span>
                                        @endif
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ Auth::user()->role=='admin'?route('invoice.show',['invoice'=>$item->id]):route('member.invoice.detail',['invoice'=>$item->id]) }}" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="bottom" title="Detail Transaksi"><i class="text-white fas fa-search"></i></a>
                                        <form action="{{ route('invoice.destroy',['invoice'=>$item->id]) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger mr-2" data-toggle="tooltip" data-placement="bottom" title="Delete Transaksi" onclick="return confirm('Are you sure?')"><i class="text-white fas fa-trash-alt"></i></button>
                                        </form>
                                        <a href="{{ url('invoice/'.$item->kode.'.'.$item->id) }}" target="d_blank" class="btn btn-info mr-2" data-toggle="tooltip" data-placement="bottom" title="Lihat Invoice"><i class="text-white fas fa-eye"></i></a>
                                        @if ($item->status==0)
                                        <form action="{{ route('invoice.update',['invoice'=>$item->id]) }}" method="post">
                                            @method('PUT')
                                            @csrf
                                            <button type="submit" class="btn btn-secondary mr-2" data-toggle="tooltip" data-placement="bottom" title="Ganti status transaksi" onclick="return confirm('Are you sure?')"><i class="text-white fas fa-pencil-alt"></i></button>
                                        </form>
                                        @endif
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
    $('.uang').mask('000.000.000.000.000', {reverse: true});
</script>
@endsection

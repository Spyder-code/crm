@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card-group">
            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $data->count() }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transaksi Saya</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="book"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ Auth::user()->komisi }}%</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Komisi Saya</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="dollar-sign"></i></span>
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
        <div class="col">
            <div class="card">
                <div class="card-header bg-success text-white">Target</div>
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
                                    {{ $memberTarget[$loop->index] }}/{{ $item->jumlah }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">List Semua Transaksi</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pembeli</th>
                                        <th>Produk</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pembeli->nama }}</td>
                                        <td>{{ $item->produk->nama }}</td>
                                        <td>
                                            @if ($item->status==0)
                                                <span class="badge badge-danger">Belum bayar</span>
                                            @elseif($item->status==1)
                                            <span class="badge badge-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            <a href="{{ Auth::user()->role=='admin'?route('invoice.show',['invoice'=>$item->id]):route('member.transaksi.detail',['invoice'=>$item->id]) }}" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="bottom" title="Detail Transaksi"><i class="text-white fas fa-search"></i></a>
                                            <a href="{{ url('invoice/'.$item->kode.'.'.$item->id) }}" target="d_blank" class="btn btn-info mr-2" data-toggle="tooltip" data-placement="bottom" title="Lihat Invoice"><i class="text-white fas fa-eye"></i></a>
                                            @if ($item->status==0)
                                            <a href="https://api.whatsapp.com/send?phone=6283857317946&text=Transaksi%20ini%20segera%20diproses!%0A%0A{{ url('/invoice/'.$item->kode.'.'.$item->id) }}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Chat admin" class="btn btn-success mr-2"><i class="text-white fas fa-envelope"></i></a>
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
</script>
@endsection

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
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Transaksi</h6>
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
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                    class="set-doller">Rp.</sup><span class="uang">{{ $pendapatan }}</span></h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Pendapatan
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
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $admin }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Transaksi Admin</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <h2 class="text-dark mb-1 font-weight-medium">{{ $member }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah Transaksi Member</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="users"></i></span>
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
                    <div class="card-header bg-primary text-white">List Semua Transaksi</div>
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
                                            <a href="https://api.whatsapp.com/send?phone=6283857317946&text=Terima%20kasih%20telah%20melakukan%20transaksi.%0AUntuk%20proses%20selanjutnya%20silahkan%20melakukan%20pembayaran%20dengan%20pilih%20opsi%20dibawah%20ini%3A%0A%0A1.%20TF%20BCA%20%20%20%20%20%20%3A%207656756756%20a.n%20spydercode%0A2.%20TF%20GoPay%20%20%3A%207878676767%20a.n%20spydercode%0A3.%20Pembayaran%20langsung%20pada%20alamat%20di%20bawah%0A%0ASalam%20kami!%0Ajl.%20kh%20usman%20mojokerto%2061328%0A%0A{{ url('/invoice/'.$item->kode.'.'.$item->id) }}" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Kirim pesan" class="btn btn-success mr-2"><i class="text-white fas fa-envelope"></i></a>
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

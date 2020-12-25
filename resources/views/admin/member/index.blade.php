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
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah semua member</h6>
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
                            <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium">{{ $aktif->count() }}</h2>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah member aktif
                            </h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="check-circle"></i></span>
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

        <div class="row mb-5">
            <div class="col">
                <h3 class="text-success"><strong>Ajak Teman Jadi Member</strong></h3><hr>
                <div class="input-group">
                    <input type="text" class="form-control" id="link1" value="{{ url('/register/'.Auth::user()->kode) }}" readonly>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" data-clipboard-target="#link1" data-toggle="tooltip" data-placement="bottom" title="Coply link"><i class="fas fa-copy"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-info text-white">List Semua Member 
                        <div class="float-right">
                            <form action="{{ route('admin.download') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')">Download Kartu Member</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Komisi</th>
                                        <th>Pendapatan</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->komisi }}%</td>
                                        <td>Rp.{{ $item->pendapatan }}</td>
                                        <td>{{ date('d F Y',strtotime($item->created_at)) }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ route('member.show',['member'=>$item->id]) }}" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="bottom" title="Detail member"><i class="text-white fas fa-search"></i></a>
                                            <form action="{{ route('member.destroy',['member'=>$item->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger mr-2" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Hapus member"><i class="text-white fas fa-trash-alt"></i></button>
                                            </form>
                                            <a href="{{ route('member.edit',['member'=>$item->id]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit member"><i class="text-white fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('admin.resetPassword') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-secondary ml-2" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Reset password member"><i class="text-white fas fa-recycle"></i></button>
                                            </form>
                                            <form action="{{ route('admin.resetPendapatan',['member'=>$item->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success ml-2" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Reset pendapatan"><i class="text-white fas fa-dollar-sign"></i></button>
                                            </form>
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
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-success text-white">List Member aktif</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="two_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Komisi</th>
                                        <th>Pendapatan</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($aktif as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->komisi }}%</td>
                                        <td>Rp. {{ $item->pendapatan }}</td>
                                        <td>{{ date('d F Y',strtotime($item->created_at)) }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{ route('member.show',['member'=>$item->id]) }}" class="btn btn-warning mr-2" data-toggle="tooltip" data-placement="bottom" title="Detail member"><i class="text-white fas fa-search"></i></a>
                                            <form action="{{ route('member.destroy',['member'=>$item->id]) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger mr-2" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Hapus member"><i class="text-white fas fa-trash-alt"></i></button>
                                            </form>
                                            <a href="{{ route('member.edit',['member'=>$item->id]) }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit member"><i class="text-white fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('admin.resetPassword') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-secondary ml-2" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Reset password member"><i class="text-white fas fa-recycle"></i></button>
                                            </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script>
    new ClipboardJS('.btn');
</script>
<script>
    $('#zero_config').DataTable();
    $('#two_config').DataTable();
</script>
@endsection

@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card-group">
            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{ $referal}}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Jumlah total referral</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="opacity-7 text-muted"><i data-feather="user-plus"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
        <hr>

        <div class="row mt-3">
            <div class="col">
                <div class="card border border-info">
                    <div class="card-header bg-info text-white">Referral Saya</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengikut</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $member)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $member->pengikut->name }}</td>
                                        <td>
                                            @if ($member->pengikut->status==0)
                                                <div class="alert alert-danger">
                                                    <strong>Tidak Aktif</strong>
                                                </div>
                                            @elseif($member->pengikut->status==1)
                                                <div class="alert alert-success">
                                                    <strong>Aktif</strong>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('member.referral.detail',['member' => $member->id]) }}" class="btn btn-warning text-white">Lihat</a>
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
    $('#zero_config').DataTable();
    new ClipboardJS('.btn');
</script>
@endsection

@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="card-group">
            <div class="card border-right">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 w-100 text-truncate font-weight-medium"><sup
                                    class="set-doller">Rp.</sup>{{ number_format($total,2,',','.') }}</h2>
                            </div>
                            <h6 class="text-muted font-weight-normal mb-0 w-100 text-truncate">Total Penarikan</h6>
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
        <div class="col text-center">
            <div class="card">
                <div class="card-header bg-success text-white">ID Member</div>
                <div class="card-body">
                    <div class="sec-1">
                        <form action="{{url('admin/scanUser')}}" method="POST">
                            @csrf
                            <input type="text" id="kode" name="kode" class="form-control text-center" autofocus style="text-transform: uppercase">
                            <button type="submit" class="btn btn-success mt-3" style="width: 200px">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-primary text-white">Riwayat penarikan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-striped table-bordered no-wrap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>ID Member</th>
                                        <th>Nama Member</th>
                                        <th>Jumlah Penarikan</th>
                                        <th>Tanggal Penarikan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->member->kode }}</td>
                                        <td>{{ $item->member->name }}</td>
                                        <td>Rp. {{ number_format($item->jumlah,2,',','.') }}</td>
                                        <td>{{ date('d F Y',strtotime($item->created_at)) }}</td>
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
<script type="text/javascript" src="{{asset('js/jquery.scannerdetection.js')}}"></script>
    <!-- CSS Here -->
<link href="{{ asset('admin/assets/extra-libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
<!-- Javascript Here -->
<script src="{{ asset('admin/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('admin/dist/js/pages/datatable/datatable-basic.init.js')}}"></script>
<script>
    $('#zero_config').DataTable();

$(document).scannerDetection({

    //https://github.com/kabachello/jQuery-Scanner-Detection

    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
    preventDefault: true,
    endChar: [13],
    onComplete: function(barcode, qty){
        validScan = true;
        $('#kode').val (barcode);
        var url = "{{url('withdraw/')}}"+"/"+barcode;
        $(location).attr('href',url);
    }, // main callback function	,
    onError: function(string, qty) {
        $('#kode').val ($('#kode').val()  + string);
    }
});


</script>
@endsection

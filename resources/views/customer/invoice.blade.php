<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.jpg') }}">
    <title>Invoice-{{ $invoice->kode }} | Garasiart</title>
    <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    <style type="text/css" media="print">
        .no-print { display: none; }
     </style>

<style>
    body{margin-top:20px;
background:#eee;
}

@media print{
    html, body {
    height:100%;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden;
  }
    @page {
            size: landscape
        }
    }
/*Invoice*/
.invoice .top-left {
    font-size:65px;
	color:#3ba0ff;
}

.invoice .top-right {
	text-align:right;
	padding-right:20px;
}

.invoice .table-row {
	margin-left:-15px;
	margin-right:-15px;
	margin-top:25px;
}

.invoice .payment-info {
	font-weight:500;
}

.invoice .table-row .table>thead {
	border-top:1px solid #ddd;
}

.invoice .table-row .table>thead>tr>th {
	border-bottom:none;
}

.invoice .table>tbody>tr>td {
	padding:8px 20px;
}

.invoice .invoice-total {
	margin-right:-10px;
	font-size:16px;
}

.invoice .last-row {
	border-bottom:1px solid #ddd;
}

.invoice-ribbon {
	width:85px;
	height:88px;
	overflow:hidden;
	position:absolute;
	top:-1px;
	right:14px;
}

.ribbon-inner {
	text-align:center;
	-webkit-transform:rotate(45deg);
	-moz-transform:rotate(45deg);
	-ms-transform:rotate(45deg);
	-o-transform:rotate(45deg);
	position:relative;
	padding:7px 0;
	left:-5px;
	top:11px;
	width:120px;
	background-color:#66c591;
	font-size:15px;
	color:#fff;
}

.ribbon-inner:before,.ribbon-inner:after {
	content:"";
	position:absolute;
}

.ribbon-inner:before {
	left:0;
}

.ribbon-inner:after {
	right:0;
}

@media(max-width:575px) {
	.invoice .top-left,.invoice .top-right,.invoice .payment-details {
		text-align:center;
	}

	.invoice .from,.invoice .to,.invoice .payment-details {
		float:none;
		width:100%;
		text-align:center;
		margin-bottom:25px;
	}

	.invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
		font-size:22px;
	}

	.invoice .btn {
		margin-top:10px;
	}
}

@media print {
	.invoice {
		width:900px;
		height:800px;
	}
}
</style>
@php( $perusahaan = \App\Company::first())
{{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> --}}

        @if ($message = Session::get('success'))
        <div class="row no-print">
            <div class="col my-3">
                <div class="alert alert-success alert-block text-center">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <h3><strong>Terima kasih sudah berbelanja</strong></h3>
                    <h3><strong>Tunggu Pesan dari admin untuk prosess selanjutnya</strong></h3>
                </div>
            </div>
        </div>
        @endif
<div class="container bootstrap snippets bootdeys bg-white" id="pdf">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default invoice" id="invoice">
            <div class="panel-body">
                <div class="invoice-ribbon">
                    @if ($invoice->status==0)
                        <div class="ribbon-inner bg-warning">UNPAID</div>
                    @else
                        <div class="ribbon-inner">PAID</div>
                    @endif
                </div>
                <div class="row">

                    <div class="col-sm-6 top-left">
                        {{-- <i class="fa fa-money-bill-alt"></i> --}}
                        <h1>{{ $perusahaan->nama }}</h1>
                        <p style="font-size: 10pt; color:gray">Alamat : {{ $perusahaan->alamat }}<br>Email : {{ $perusahaan->email }}<br>No. Telp : {{ $perusahaan->phone }}
                        </p>
                    </div>

                    <div class="col-sm-6 top-right">
                            <h3 class="marginright">INVOICE-{{ $invoice->kode }}</h3>
                            <span class="marginright">{{ date('d F Y',strtotime($invoice->updated_at)) }}</span>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <div class="col-sm-6 from">
                        <p class="lead">From : {{ $invoice->member->name }}</p>
                        <p>{{ $invoice->member->alamat }}</p>
                        <p>Phone: {{ $invoice->member->phone }}</p>
                    </div>

                    <div class="col-sm-6 to">
                        <p class="lead">To : {{ $invoice->pembeli->nama }}</p>
                        <p>{{ $invoice->pembeli->alamat }}</p>
                        <p>Phone: {{ $invoice->pembeli->phone }}</p>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                    <thead>
                        <tr>
                        <th class="text-center" style="width:5%">#</th>
                        <th style="width:50%">Item</th>
                        <th class="text-right" style="width:15%">Quantity</th>
                        <th class="text-right" style="width:15%">Unit Price</th>
                        <th class="text-right" style="width:15%">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">1</td>
                            <td>{{ $invoice->produk->nama }}</td>
                            <td class="text-right">{{ $invoice->jumlah }}</td>
                            <td class="text-right">Rp. {{ $invoice->harga->harga }}</td>
                            <td class="text-right">Rp. {{ $invoice->total }}</td>
                        </tr>
                    </tbody>
                    </table>

                </div>

                <div class="row">
                    <div class="col-sm-6 margintop">
                        {{-- <p class="lead marginbottom">THANK YOU!</p>

                        <button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
                        <button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Mail Invoice</button> --}}
                    </div>
                    <div class="col-sm-6 text-right pull-right invoice-total">
                            <p>Total : Rp. {{ $invoice->total }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
</div>
<div class="container no-print">
    <div class="row mb-5">
        <div class="col-sm-6 float-right mt-3">
            <button class="btn btn-success" onclick="window.print()" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
        </div>
    </div>
</div>

<script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
{{-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
    <!-- Below script will print div with id pdf to a pdf file using jspdf -->
    <script type="text/javascript">
        $("#invoice-print").live("click", function () {
            var printDoc = new jsPDF();
            printDoc.fromHTML($('#pdf').get(0), 10, 10, {
                'width': 180
            });
            printDoc.save('invoice.pdf')
            // this opens a new popup,  after this the PDF opens the print window view but there are browser inconsistencies with how this is handled
        });
    </script> --}}
</body>

</html>

<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Adminmart Template - The Ultimate Multipurpose admin template</title>
    <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<style>
    .img-profile{
    position: absolute;
    top: 200px;
    margin-left: 100px;
}
td{
    font-size: 20pt;
}
h1{
    margin-left: 300px;
    font-size: 50pt;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    color: lightskyblue;
}
.img{
    height: 200px;
    margin-left: 100px;
    margin-top: 50px;
}
.banner{
    height: 300px;
    background-image:url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/amazon-rivet-furniture-1533048038.jpg?crop=1.00xw:0.502xh;0,0.423xh&resize=1200:*');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center

}
</style>

<body>
    @php( $perusahaan = \App\Company::first())

    <div class="bg-info banner">
	</div>
	<div class="img-profile">
		<img src="{{ $user->image }}" class="rounded-circle border border-primary" style="width:196px; height:196px">
	</div>

	<div class="container">
		<div class="row">
			<div class="col-8 mt-2 p-3">
				<h1>{{ $perusahaan->nama }}</h1>
				<table  border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td width="40%">ID</td>
							<td width="5%">:</td>
							<td> {{ $user->kode }}</td>
						</tr>
						<tr>
							<td width="40%">Nama</td>
							<td width="5%">:</td>
							<td> {{ $user->name }}</td>
						</tr>
						<tr>
							<td width="40%">Alamat</td>
							<td width="5%">:</td>
							<td> {{ $user->alamat }}</td>
						</tr>
						<tr>
							<td width="40%">No. Telp</td>
							<td width="5%">:</td>
							<td> {{ $user->phone }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col">
				<div>
					<img class="img img-fluid" src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/register/'.$user->kode), 'QRCODE')}}" alt="barcode" />
				</div>
			</div>
		</div>
    </div>

    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js')}} "></script>
    <!-- Bootstraether Core JavaScript -->
    <script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js')}} "></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}} "></script>
    <!-- ============================================================== -->
    <!-- This page plugin js -->
    <!-- ============================================================== -->
    <script>
        $(".preloader ").fadeOut();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>

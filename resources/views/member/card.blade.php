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
/* .banner{
    height: 300px;
    background-image:url('https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/amazon-rivet-furniture-1533048038.jpg?crop=1.00xw:0.502xh;0,0.423xh&resize=1200:*');
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center
} */
#isi{
    position: absolute;
    top: 10px;
}

td{
    font-size: 30pt;
    color: black;
    text-shadow: 2px 2px gray;
    margin-left: 10px;
}

#bar{
    position: absolute;
    top: 380px
}

#qr{
    width: 250px;
    height: 200px;
}
#br{
    margin-top: 150px;
    top: 30px;

}
#brr{
    position: absolute;
    margin-top: 490px;
    top: 30px;
}
</style>

<body>
    <img src="{{ asset('card/depan.jpg') }}" class="img-fluid" width="100%;" style="height: 630px;">
	<div class="container-fluid" id="isi">
		<div class="row">
			<div class="col-8 mt-2 px-4">
				<table  border="0" cellspacing="0" cellpadding="0">
					<tbody>
						<tr>
							<td width="40%">ID Member</td>
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
					</tbody>
                </table>
                <div class="bg-white p-2 text-center" id="brr">
                    <img class="img img-fluid" src="data:image/png;base64,{{DNS1D::getBarcodePNG($user->kode, 'C128')}}" alt="barcode" style="height: 50px" />
                </div>
			</div>
			<div class="col mr-3">
                <div class="row" id="bar">
                    {{-- <div class="col">
                        <div class="bg-white p-2" id="br">
                            <img class="img img-fluid mr-5" src="data:image/png;base64,{{DNS1D::getBarcodePNG($user->kode, 'C128')}}" alt="barcode" style="height: 50px" />
                        </div>
                    </div> --}}
                    <div class="col" style="margin-left:130px">
                        <div class="bg-white p-2">
                            <img class="img img-fluid" id="qr" src="data:image/png;base64,{{DNS2D::getBarcodePNG(url('/register/'.$user->kode), 'QRCODE')}}" alt="barcode" />
                        </div>
                    </div>
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

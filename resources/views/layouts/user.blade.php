<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.jpg') }}">
        <!-- Primary Meta Tags -->
        <title>@yield('title')</title>
        <meta name="title" content="Rekomendasi karya seni yang cocok untuk menghias dinding ruangan Anda">
        <meta name="description" content="@yield('deskripsi')">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:title" content="Rekomendasi karya seni yang cocok untuk menghias dinding ruangan Anda">
        <meta property="og:description" content="@yield('deskripsi')">
        <meta property="og:image" content="@yield('image')">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url('/') }}">
        <meta property="twitter:title" content="Rekomendasi karya seni yang cocok untuk menghias dinding ruangan Anda">
        <meta property="twitter:description" content="@yield('deskripsi')">
        <meta property="twitter:image" content="@yield('image')">
        <link href="{{ asset('admin/dist/css/style.min.css') }}" rel="stylesheet">
</head>

<body>
    @php( $perusahaan = \App\Company::first())
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative"
            style="background:url({{ asset('admin/assets/images/big/auth-bg.jpg') }}) no-repeat center center;">
            <div class="auth-box row">
                @yield('content')
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Login box.scss -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- All Required js -->
    <!-- ============================================================== -->
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

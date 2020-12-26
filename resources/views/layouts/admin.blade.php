<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.jpg') }}">
    <title>Dashboard</title>
    <link href="{{ asset('admin/assets/extra-libs/c3/c3.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/libs/chartist/dist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.css')}}" rel="stylesheet" />
    <link href="{{ asset('admin/dist/css/style.min.css')}}" rel="stylesheet">
</head>

<body>
    @php( $perusahaan = \App\Company::first())
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
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md">
                <div class="navbar-header" data-logobg="skin6">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-brand">
                        <!-- Logo icon -->
                        <a href="main-dashboard">
                            <b class="logo-icon">
                                <!-- Dark Logo icon -->
                                <img src="{{ $perusahaan->banner }}" alt="homepage" style="height: 45px; max-width:180px; min-width:60px" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="{{ $perusahaan->banner }}" alt="homepage" style="height: 75px; max-width:180px; min-width:150px" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text -->
                            {{-- <span class="logo-text">
                                <!-- dark Logo text -->
                                <img src="{{ asset('admin/assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                                <!-- Light Logo text -->
                                <img src="{{ asset('admin/assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" />
                            </span> --}}
                        </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-left mr-auto ml-3 pl-1">
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        {{-- <li class="nav-item d-none d-md-block">
                            <a class="nav-link" href="javascript:void(0)">
                                <form>
                                    <div class="customize-input">
                                        <input class="form-control custom-shadow custom-radius border-0 bg-white"
                                            type="search" placeholder="Search" aria-label="Search">
                                        <i class="form-control-icon" data-feather="search"></i>
                                    </div>
                                </form>
                            </a>
                        </li> --}}
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->image }}" class="rounded-circle"
                                    width="40">
                                <span class="ml-2 d-none d-lg-inline-block">
                                    <span class="text-dark">{{ Auth::user()->panggilan }}</span>
                                    <i data-feather="chevron-down" class="svg-icon"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated flipInY">
                                <a class="dropdown-item" href="{{ Auth::user()->role=='admin'? route('admin.profile'): route('member.profile') }}"><i data-feather="user"
                                        class="svg-icon mr-2 ml-1"></i>
                                    My Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="return confirm('Are You sure?')"><i data-feather="power"
                                        class="svg-icon mr-2 ml-1"></i>
                                    Logout</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav mb-5">
                    <ul id="sidebarnav">
                        @if (Auth::user()->role=='admin')
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.dashboard') }}"
                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                class="hide-menu">Dashboard</span></a></li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Product</span></li>

                    <li class="sidebar-item"> <a class="sidebar-link" href="{{ route('produk.index') }}"
                            aria-expanded="false"><i data-feather="tag" class="feather-icon"></i><span class="hide-menu">List Produk</span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('produk.create') }}"
                            aria-expanded="false"><i data-feather="plus-square" class="feather-icon"></i><span
                                class="hide-menu">Tambah Produk</span></a></li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Member</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.index') }}"
                            aria-expanded="false"><i data-feather="users" class="feather-icon"></i><span
                                class="hide-menu">List Member
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.create') }}"
                            aria-expanded="false"><i data-feather="user-plus" class="feather-icon"></i><span
                                class="hide-menu">Tambah Member
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.referral') }}"
                            aria-expanded="false"><i data-feather="user-check" class="feather-icon"></i><span
                                class="hide-menu">Referral Member
                            </span></a>
                    </li>
                    {{-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.activity') }}"
                            aria-expanded="false"><i data-feather="sidebar" class="feather-icon"></i><span
                                class="hide-menu">Aktivitas Member
                            </span></a>
                    </li> --}}
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Transaksi</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('invoice.index') }}"
                            aria-expanded="false"><i data-feather="book" class="feather-icon"></i><span
                                class="hide-menu">List Transaksi
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('withdraw.index') }}"
                            aria-expanded="false"><i data-feather="dollar-sign" class="feather-icon"></i><span
                                class="hide-menu">Penarikan
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('invoice.create') }}"
                            aria-expanded="false"><i data-feather="crosshair" class="feather-icon"></i><span
                                class="hide-menu">Target Penjualan
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.promosi') }}"
                            aria-expanded="false"><i data-feather="tv" class="feather-icon"></i><span
                                class="hide-menu">Buat Promosi
                            </span></a>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.customer') }}"
                            aria-expanded="false"><i data-feather="user" class="feather-icon"></i><span
                                class="hide-menu">List Pembeli
                            </span></a>
                    </li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('admin.profile') }}"
                    aria-expanded="false"><i data-feather="edit-3" class="feather-icon"></i><span class="hide-menu">Profile</span></a></li>
                    {{-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="pesan"
                    aria-expanded="false"><i data-feather="edit-3" class="feather-icon"></i><span class="hide-menu">Pesan Masuk</span></a></li> --}}
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('logout') }}" onclick="return confirm('Are You sure?')"
                            aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                                class="hide-menu">Logout</span></a></li>
                @else
                        <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.dashboard') }}"
                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                                class="hide-menu">Dashboard</span></a></li>
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Product</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.promosi') }}"
                            aria-expanded="false"><i data-feather="tv" class="feather-icon"></i><span
                                class="hide-menu">Promosi Produk</span></a></li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Transaksi</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.transaksi') }}"
                            aria-expanded="false"><i data-feather="book" class="feather-icon"></i><span
                                class="hide-menu">Transaksi Saya
                            </span></a>
                    </li>
                    {{-- <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="transaksiPelayanan"
                            aria-expanded="false"><i data-feather="sidebar" class="feather-icon"></i><span
                                class="hide-menu">Buat Invoice
                            </span></a>
                    </li> --}}
                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.profile') }}"
                    aria-expanded="false"><i data-feather="edit-3" class="feather-icon"></i><span class="hide-menu">Profile</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('member.referral') }}"
                    aria-expanded="false"><i data-feather="user-check" class="feather-icon"></i><span class="hide-menu">Referral Saya</span></a></li>
                    <li class="sidebar-item"> <a class="sidebar-link sidebar-link" href="{{ route('logout') }}" onclick="return confirm('Are You sure?')"
                            aria-expanded="false"><i data-feather="log-out" class="feather-icon"></i><span
                                class="hide-menu">Logout</span></a></li>
                        @endif
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @yield('content')
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('admin/assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{ asset('admin/assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="{{ asset('admin/dist/js/app-style-switcher.js')}}"></script>
    <script src="{{ asset('admin/dist/js/feather.min.js')}}"></script>
    <script src="{{ asset('admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{ asset('admin/dist/js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('admin/dist/js/custom.min.js')}}"></script>
    <script src="{{ asset('admin/assets/extra-libs/c3/d3.min.js')}}"></script>
    <script src="{{ asset('admin/assets/extra-libs/c3/c3.min.js')}}"></script>
    {{-- <script src="{{ asset('admin/assets/libs/chartist/dist/chartist.min.js')}}"></script>
    <script src="{{ asset('admin/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js')}}"></script> --}}
    <script src="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('admin/assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js')}}"></script>
    {{-- <script src="{{ asset('admin/dist/js/pages/dashboards/dashboard1.min.js')}}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>

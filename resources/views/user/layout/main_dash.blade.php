<!DOCTYPE html>
<html lang="en">

<!-- molla/dashboard.html  22 Nov 2019 10:03:13 GMT -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Marketplace Rumah Kreatif Toba">
    <meta name="author" content="p-themes">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('asset/Image/logo_rkt.png') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/bootstrap.min.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/style.css') }}">
		<link rel="stylesheet" href="{{ URL::asset('css/app.css')}}">
		<link rel="stylesheet" href="{{ URL::asset('css/statusOrder.css')}}">
</head>

<body>
    <div class="page-wrapper">
        @include('user.layout.header_dash')

        <main class="main">
            <div class="page-header text-center"
                style="background-image: url('{{ URL::asset('asset/Molla/assets/images/page-header-bg.jpg') }}')">
                <div class="container">
                    <!-- <h1 class="page-title">My Account<span>Shop</span></h1> -->
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-3">
                <div class="container">
                    <ol class="breadcrumb">
                        @yield('breadcrumb')
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="dashboard">
                    <div class="container">
                        <div class="row">
                            <aside class="col-md-4 col-lg-3">
                                <ul class="nav nav-dashboard flex-column mb-3 mb-md-0" role="tablist">
                                    <li class="nav-item">
                                        <!-- <a class="nav-link active" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="true">Dashboard</a> -->
                                        <!-- <a class="nav-link" id="tab-dashboard-link" data-toggle="tab" href="#tab-dashboard" role="tab" aria-controls="tab-dashboard" aria-selected="false">Dashboard</a> -->
                                        <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/toko') }}">Toko</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/daftar_pembelian') }}">Pesananku</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ route('rentalku') }}">Pesanan Rentalku</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/chat') }}">Chat</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/keranjang') }}">Keranjangku</a>
								    </li>
                                    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/daftar_keinginan') }}">Wishlist</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/profil') }}">Profil</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/daftar_alamat') }}">Alamat</a>
								    </li>
								    <li class="nav-item">
								        <a class="nav-link" href="{{ url('/logout') }}">Keluar</a>
								    </li>
								</ul>
	                		</aside><!-- End .col-lg-3 -->

                            <div class="col-md-8 col-lg-9">
                                <div class="tab-content">
                                    @yield('container')
                                </div>
                            </div><!-- End .col-lg-9 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .dashboard -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        @include('user.layout.footer')

    </div><!-- End .page-wrapper -->

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    @include('user.layout.mobile_menu_dash')

    <!-- Plugins JS File -->
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/superfish.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/owl.carousel.min.js') }}"></script>
    <!-- Main JS File -->
    <script src="{{ URL::asset('asset/Molla/assets/js/main.js') }}"></script>
		<script src="{{ URL::asset('asset/js/function_4.js') }}"></script>
</body>


<!-- molla/dashboard.html  22 Nov 2019 10:03:13 GMT -->
<<<<<<< HEAD

=======
>>>>>>> d4f68a0f393bfe4ea485e3628a35299507154b78
</html>

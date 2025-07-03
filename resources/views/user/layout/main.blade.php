<!DOCTYPE html>
<html lang="en">

<!-- molla/index-1.html  22 Nov 2019 09:55:06 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Marketplace Rumah Kreatif Toba">
    <meta name="author" content="p-themes">
    <!--Pure css-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chatbot.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('asset/Image/logo_rkt_title.png') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/jquery.countdown.css') }}">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/skins/skin-demo-2.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/demos/demo-2.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('asset/Molla/assets/css/plugins/nouislider/nouislider.css') }}">
</head>

<body>
<div class="page-wrapper">
    @include('user.layout.header')

    @yield('container')

    @include('user.layout.footer')

</div><!-- End .page-wrapper -->

<button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

@include('user.layout.mobile_menu')

@include('user.login_register_modal')

<!-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ URL::asset('asset/Molla/assets/images/popup/newsletter/logo.png') }}" class="logo" alt="logo" width="60" height="15">
                            <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
                            <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite products.</p>
                            <form action="#">
                                <div class="input-group input-group-round">
                                    <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
                                    <div class="input-group-append">
                                        <button class="btn" type="submit"><span>go</span></button>
                                    </div>
                                </div>
                            </form>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                <label class="custom-control-label" for="register-policy-2">Do not show this popup again</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2-5col col-lg-5 ">
                        <img src="{{ URL::asset('asset/Molla/assets/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img" alt="newsletter">
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Plugins JS File -->
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/superfish.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('asset/Molla/assets/js/jquery.countdown.min.js') }}"></script>

    <script src="{{ URL::asset('asset/Molla/assets/js/wNumb.js') }}"></script>
    <!-- <script src="{{ URL::asset('asset/Molla/assets/js/nouislider.min.js') }}"></script> -->

<!-- <script src="{{ URL::asset('asset/Molla/assets/js/bootstrap-input-spinner.js') }}"></script> -->
<script src="{{ URL::asset('asset/Molla/assets/js/jquery.elevateZoom.min.js') }}"></script>
<script src="{{ URL::asset('asset/Molla/assets/js/jquery.magnific-popup.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ URL::asset('asset/Molla/assets/js/main.js') }}"></script>
<script src="{{ URL::asset('asset/Molla/assets/js/demos/demo-2.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('js')
</body>


<!-- molla/index-1.html  22 Nov 2019 09:55:32 GMT -->
</html>

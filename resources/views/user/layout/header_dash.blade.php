<style>
    .menu li:hover>a,
    .menu li.show>a,
    .menu li.active>a {
        color: #800000;
    }

    .header-bottom .menu>li>a:before {
        background-color: #800000;
    }

    .nav-link[data-toggle].collapsed:after {
        content: " ▾";
    }

    .nav-link[data-toggle]:not(.collapsed):after {
        content: " ▴";
    }

    .fs-7 {
        font-size: 12px !important;
    }

    .fs-6 {
        font-size: 14px !important;
    }
    .menu li:hover>a, .menu li.show>a, .menu li.active>a{
        color: #F15743;
    }

    .header-bottom .menu>li>a:before{
        background-color: #F15743;
    }


    /* .icon:hover{
        color: #F15743
    } */
</style>
<header class="header">
    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('/') }}" class="logo" style="margin:0">
                    <img src="{{ URL::asset('asset/Image/logo_rkt.png') }}" alt="RKT Logo" width="65">
                </a>

                <a class="logo" style="margin:0px 0px 0px 20px">
                    <img src="{{ URL::asset('asset/Image/Bangga_Buatan_Indonesia_Logo.png') }}" alt="BBI Logo"
                        width="50">
                </a>

                <a class="logo" style="margin:0px 0px -5px 20px">
                    <img src="{{ URL::asset('asset/Image/logo_pemkab_toba.png') }}" alt="BBI Logo" width="50">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="megamenu-container">
                            <a href="{{ url('/produk') }}">Produk</a>
                        </li>
                        <li class="megamenu-container">
                            <a href="{{ url('/experience') }}">Experience</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="header-right">
                <div class="header-search">
                    <a href="#" class="search-toggle" role="button" title="Search"><i
                            class="icon-search"></i></a>
                    <form action="{{ url('/cari') }}" id="form_cari" method="post">
                        @csrf
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="cari" id="cari" placeholder="Cari di Rumah Kreatif Toba" value="{{ old('cari') }}" required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->

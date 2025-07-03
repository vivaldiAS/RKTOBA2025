<style>
    .menu li:hover>a,
    .menu li.show>a,
    .menu li.active>a {
        color: #F15743;
    }

    .header-bottom .menu>li>a:before {
        background-color: #F15743;
    }

    .header-intro-clearance .header-bottom .container::before {
        visibility: hidden;
    }

    .header-intro-clearance .header-bottom .container::after {
        visibility: hidden;
    }

    .header-right .wishlist>a:hover {
        color: #F15743;
    }

    .header-right .cart-dropdown {
        padding: 0;
        margin-left: 1.5rem;
    }

    .header-right .cart-dropdown>a:hover {
        color: #F15743;
    }

    .header-right .account {
        padding: 0;
        margin-left: 1.5rem;
    }

    .header-right .account>a:hover {
        color: #F15743;
    }


    /* .icon:hover{
        color:#F15743;
    } */
</style>

<header class="header header-2 header-intro-clearance sticky-header">
    <div class="header-middle">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <span class="sr-only">Toggle mobile menu</span>
                    <i class="icon-bars"></i>
                </button>

                <a href="{{ url('/') }}" class="logo" style="margin:0">
                    <img src="{{ URL::asset('asset/Image/logo_rkt.png') }}" alt="RKT Logo" width="65">
                </a>

                <a class="logo" style="margin:0px 0px -5px 20px">
                    <img src="{{ URL::asset('asset/Image/logo_pemkab_toba.png') }}" alt="BBI Logo" width="50">
                </a>

                        <!-- <h5 class="logo" style="color: #F15743;">Rumah Kreatif Toba</h5> -->
            </div><!-- End .header-left -->

            <div class="header-center" >
                <div
                    class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                    <form action="{{ url('/cari') }}" id="form_cari" method="post">
                        @csrf
                        <div class="header-search-wrapper search-wrapper-wide">
                            <!-- <label for="cari" class="sr-only">Search</label> -->
                            <input type="search" class="form-control" name="cari" id="cari"
                                placeholder="Cari di Rumah Kreatif Toba" value="{{ old('cari') }}" required>
                            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                    <script>
                        // function cari_produk() {
                        //     var cari_produk = document.getElementById("cari_produk").value;
                        //     document.getElementById("form_cari_produk").setAttribute("action", "{{ url('/produk/cari/"cari_produk"') }}",);
                        //     // document.getElementById("form_cari_produk").submit();
                        // }
                    </script>
                </div><!-- End .header-search -->
                
            </div>

            <div class="header-right">

                @if (Auth::check())
                    <!-- <div class="wishlist">
                    <a href="wishlist.html" title="Wishlist">
                        <div class="icon">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge">3</span>
                        </div>
                        <p>Keinginan</p>
                    </a>
                </div> -->

                    <div class="wishlist">
                    <a href="./../daftar_keinginan" title="Wishlist">
                        <div class="icon" id="jumlah_produk_keinginan">
                            <i class="icon-heart-o"></i>
                            <span class="wishlist-count badge">
                                <?php $jumlah_produk_keinginan = DB::table('wishlists')
                                    ->where('user_id', Auth::user()->id)
                                    ->count(); ?>
                                {{$jumlah_produk_keinginan}}
                            </span>
                        </div>
                        <p>Wishlist</p>
                    </a>
                </div>

                    <div class="cart-dropdown">
                        <a href="../keranjang" class="dropdown-toggle">
                            <div class="icon" id="jumlah_produk_keranjang">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">
                                    <?php $jumlah_produk_keranjang = DB::table('carts')
                                        ->where('user_id', Auth::user()->id)
                                        ->count(); ?>
                                    {{ $jumlah_produk_keranjang }}
                                </span>
                            </div>
                            <p>Keranjang</p>
                        </a>
                    </div><!-- End .cart-dropdown -->

                    <!-- <div style="margin-left: 1.5rem;">
                    <p style="font-size: 3rem;">|</p>
                </div> -->

                    <div class="wishlist">
                        <a href="{{ url('/dashboard') }}">
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                            <p><b><?php echo Auth::user()->username; ?></b></p>
                        </a>
                    </div><!-- End .compare-dropdown -->
                @else
                    <div class="wishlist">
                        <a href="#signin-modal" data-toggle="modal" title="My account">
                            <div class="icon">
                                <i class="icon-user"></i>
                            </div>
                            <p>Akun</p>
                        </a>
                    </div><!-- End .compare-dropdown -->
                @endif

            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom ">
        <div class="container">
            <div class="header-center">
                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container">
                            <a href="{{ url('/produk') }}">Produk</a>
                        </li>
                        <p>|</p>
                        <li class="megamenu-container">
                            <a href="{{ url('/experience') }}">Experience</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header><!-- End .header -->

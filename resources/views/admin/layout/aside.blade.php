<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link" style="background-color: #f8f9fa">
        <img src="{{ URL::asset('asset/Image/logo_rkt.png') }}" alt="Logo" class="brand-image">
        <span class="brand-text font-weight-light" style="color:black">Rumah Kreatif Toba</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <!-- <img src="{{ URL::asset('asset/AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> -->
            </div>
            <div class="info">
                <a href="#" class="d-block"><b>ADMIN</b></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
            <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
            </button>
            </div>
        </div>
    </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->

                <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
                <i class="right fas fa-angle-left"></i>
            </a>
        </li> -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <li class="nav-header">PEMBELIAN</li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_pembelian') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Pembelian</p>
                    </a>
                </li>

                <li class="nav-header">Pemesanan</li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_pemesanan') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Pemesanan Tiket</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_pemesanan-rental') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Pemesanan Rental</p>
                    </a>
                </li>

                <li class="nav-header">VOUCHER</li>
                <li class="nav-item">
                    <a href="{{ url('/voucher') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Voucher</p>
                    </a>
                </li>
                <li class="nav-header">USERS</li>
                <li class="nav-item">
                    <a href="{{ url('/user') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-header">TOKO</li>
                <li class="nav-item">
                    <a href="{{ url('/toko_user') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Toko User</p>
                    </a>
                </li>
                <li class="nav-header">WAREHOUSE</li>
                <li class="nav-item">
                    <a href="{{ route('admin.warehouse.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Dashboard Warehouse</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Stok Warehouse
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.produk.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produk Warehouse</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.pembelianproduk.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.transaksiwarehouse.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaksi Warehouse</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stokopname.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stok Opname</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Laporan Warehouse
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.laporanpemesanan.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Pemesanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.laporanstok.warehouse') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laporan Stok</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">PRODUK</li>
                <li class="nav-item">
                    <a href="{{ url('/produk_toko') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Produk Toko</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Gallery
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.gallery.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Gallery Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gallery.history') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>History</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.request.gallery.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Request Gallery</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.gallery.checkout') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Checkout</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/produksupplier_toko') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Produk Grosir</p>
                    </a>
                </li>
                <li class="nav-header">KATEGORI</li>
                <li class="nav-item">
                    <a href="{{ url('/kategori_produk') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
            <a href="{{ url('/sub_kategori') }}" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>Sub Kategori</p>
            </a>
        </li> -->
                <li class="nav-item">
                    <a href="{{ url('/kategori_tipe_spesifikasi') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Kategori Tipe Spesifikasi</p>
                    </a>
                </li>
                <li class="nav-header">KATEGORI PRODUK GROSIR</li>
                <li class="nav-item">
                    <a href="{{ url('/kategori_produk_supplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kategori_tipe_spesifikasi_produk_supplier') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Kategori Tipe Spesifikasi</p>
                    </a>
                </li>
                <li class="nav-header">SPESIFIKASI</li>
                <li class="nav-item">
                    <a href="{{ url('/tipe_spesifikasi') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Tipe Spesifikasi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/spesifikasi') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Spesifikasi</p>
                    </a>
                </li>
                <li class="nav-header">REKENING</li>
                <li class="nav-item">
                    <a href="{{ url('/daftar_rekening') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Rekening</p>
                    </a>
                </li>
                <li class="nav-header">BANK</li>
                <li class="nav-item">
                    <a href="{{ url('/bank') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Bank</p>
                    </a>
                </li>
                <li class="nav-header">CAROUSEL</li>
                <li class="nav-item">
                    <a href="{{ url('/carousel') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Carousel</p>
                    </a>
                </li>
                <li class="nav-header">ChatBot</li>
                <li class="nav-item">
                    <a href="{{ url('/admin/chatbot/model') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Model</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/chatbot/dataset') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Dataset</p>
                    </a>
                </li>
                <li class="nav-header"></li>
                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link">
                        <i class="nav-icon far fa-circle text-danger"></i>
                        <p class="text">Keluar</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

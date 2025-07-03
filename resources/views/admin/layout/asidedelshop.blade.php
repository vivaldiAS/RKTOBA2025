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
                <li class="nav-item">
                    <a href="{{ url('/admin/delshop') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
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
                            <a href="{{ url('/admin/delshop/produk') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Produk Warehouse</p>
                            </a>
                        </li>
                    </ul>
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

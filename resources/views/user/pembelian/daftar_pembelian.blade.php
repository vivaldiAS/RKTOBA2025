@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

<!-- <link rel="stylesheet" href="../bootstrap/pesananku_all.css"> -->

@section('container')

<div class="card-header px-4 py-5">
    <h5 class="text-muted mb-0">Pesanan Anda, <span style="color:#F15743;;">{{$profile->username}}</span>!</h5>
</div>
    <div class="card-body p-4">
        <div class="col-md-16">
            <div class="menu-one">
                <h5>Status</h5>
                <ul class="nav nav-tabs border-0">
                    <li class="nav-item btn-menus">
                        <a class="nav-link btns active" data-toggle="tab" href="#menu1">Semua</a>
                    </li>
                    <li class="nav-item btn-menus">
                        <a id="a-menu2" class="nav-link" data-toggle="tab" href="#menu2">Berlangsung</a>
                    </li>
                    <li class="nav-item btn-menus">
                        <a class="nav-link" data-toggle="tab" href="#menu3">Berhasil</a>
                    </li>
                    <li class="nav-item btn-menus">
                        <a class="nav-link" data-toggle="tab" href="#menu4">Dibatalkan</a>
                    </li>
                </ul>
            </div>

            {{-- Menu awal --}}
            <div class="tab-content">
                <div id="menu1" class="tab-pane active">
                    @include('user.pembelian.tab_semua_pesanan')
                </div>
                <div id="menu2" class="tab-pane" >
                    <div class="menus-two">
                        <ul class="nav nav-tabs border-0">
                            <li class="nav-item btn-menus">
                                <a class="nav-link btns active" data-toggle="tab" href="#menu2link1">Belum Bayar</a>
                            </li>
                            <li class="nav-item btn-menus">
                                <a class="nav-link" data-toggle="tab" href="#menu2link2">Pembayaran Belum dikonfirmasi</a>
                            </li>
                            <li class="nav-item btn-menus">
                                <a class="nav-link" data-toggle="tab" href="#menu2link3">Sedang Dikemas</a>
                            </li>
                            <li class="nav-item btn-menus">
                                <a class="nav-link" data-toggle="tab" href="#menu2link4">Dalam Perjalanan</a>
                            </li>
                            <!-- <li class="nav-item btn-menus">
                                <a class="nav-link" data-toggle="tab" href="#menu2link5">Belum Diambil</a>
                            </li> -->
                            <li class="nav-item btn-menus">
                                <a class="nav-link" data-toggle="tab" href="#menu2link6">Belum Dikonfirmasi Pembeli</a>
                            </li>
                        </ul>
                    </div>
                        {{-- Menu Kedua --}}
                    <div class="tab-content">
                        <div id="menu2link1" class="tab-pane active">
                            @include('user.pembelian.tab_pesanan_belum_bayar')
                        </div>
                        <div id="menu2link2" class="tab-pane">
                            @include('user.pembelian.tab_pembayaran_belum_dikonfirmasi')
                        </div>
                        <div id="menu2link3" class="tab-pane">
                            @include('user.pembelian.tab_sedang_dikemas')
                        </div>
                        <div id="menu2link4" class="tab-pane">
                            @include('user.pembelian.tab_pesanan_dalam_perjalanan')
                        </div>
                        <!-- <div id="menu2link5" class="tab-pane">
                            @include('user.pembelian.tab_pesanan_belum_diambil')
                        </div> -->
                        <div id="menu2link6" class="tab-pane">
                            @include('user.pembelian.tab_pesanan_belum_dikonfirmasi_pembeli')
                        </div>
                    </div>

                </div>
                <div id="menu3" class="tab-pane">
                    @include('user.pembelian.tab_pesanan_berhasil')
                </div>
                <div id="menu4" class="tab-pane">
                    @include('user.pembelian.tab_pesanan_dibatalkan')
                </div>
            </div>

        </div>
            </div>
            <div class="tab-pane fade" id="tab_jasa_kreatif" role="tabpanel" aria-labelledby="tab_jasa_kreatif_tab">
                <ul class="nav nav-tabs nav-tabs-bg" id="tabs-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab_semua_pesanan_jasa_kreatif_tab" data-toggle="tab" href="#tab_semua_pesanan_jasa_kreatif" role="tab" aria-controls="tab_semua_pesanan_jasa_kreatif" aria-selected="true">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_waiting_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_waiting" role="tab" aria-controls="tab_pesanan_jasa_kreatif_waiting" aria-selected="true">Menunggu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_approved_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_approved" role="tab" aria-controls="tab_pesanan_jasa_kreatif_approved" aria-selected="true">Belum Bayar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_payment_validation_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_payment_validation" role="tab" aria-controls="tab_pesanan_jasa_kreatif_payment_validation" aria-selected="true">Validasi Pembayaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_on_process_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_on_process" role="tab" aria-controls="tab_pesanan_jasa_kreatif_on_process" aria-selected="true">Dalam Proses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_declined_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_declined" role="tab" aria-controls="tab_pesanan_jasa_kreatif_declined" aria-selected="true">Dibatalkan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_done_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_done" role="tab" aria-controls="tab_pesanan_jasa_kreatif_done" aria-selected="true">Selesai</a>
                    </li>
                </ul>
                <div class="tab-content tab-content-border" id="tab-content-1">
                    <div class="tab-pane fade show active" id="tab_semua_pesanan_jasa_kreatif" role="tabpanel" aria-labelledby="tab_semua_pesanan_jasa_kreatif_tab">
                        @include('user.pembelian.tab_semua_pesanan_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_waiting" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_waiting_tab">
                        @include('user.pembelian.tab_pembelian_waiting_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_approved" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_approved_tab">
                        @include('user.pembelian.tab_pembelian_approved_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_payment_validation" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_payment_validation_tab">
                        @include('user.pembelian.tab_pembelian_payment_validation_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_on_process" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_on_process_tab">
                        @include('user.pembelian.tab_pembelian_on_progress_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_declined" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_declined_tab">
                        @include('user.pembelian.tab_pembelian_declined_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_done" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_done_tab">
                        @include('user.pembelian.tab_pembelian_done_jasa_kreatif')
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


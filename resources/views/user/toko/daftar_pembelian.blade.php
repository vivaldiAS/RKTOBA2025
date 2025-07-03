@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

<link rel="stylesheet" href="../bootstrap/pesananku_all.css">

@section('container')

<div class="card-header px-4 py-5">
    <h5 class="text-muted mb-0">Daftar Pembelian <span style="color: #F15743;">Pelanggan</span></h5>
</div>

<div class="card-body p-4">
    <div class="col-md-16">
        <div class="menu-one">
        <ul class="nav nav-tabs border-0" id="tabs-1" role="tablist">
            <li class="nav-item btn-menus">
                <a class="nav-link active" id="tab_produk_pesanan_tab" data-toggle="tab" href="#tab_produk_pesanan" role="tab" aria-controls="tab_produk_pesanan" aria-selected="true">Produk</a>
            </li>
            <li class="nav-item btn-menus">
                <a class="nav-link" id="tab_jasa_kreatif_tab" data-toggle="tab" href="#tab_jasa_kreatif" role="tab" aria-controls="tab_jasa_kreatif" aria-selected="false">Jasa Kreatif</a>
            </li>
        </ul>
        </div>
        <div class="tab-content tab-content-border" id="tab-content-1">
            <div class="tab-pane fade show active" id="tab_produk_pesanan" role="tabpanel" aria-labelledby="tab_produk_pesanan_tab">
                <ul class="nav nav-tabs nav-tabs-bg" id="tabs-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab_semua_pembelian_tab" data-toggle="tab" href="#tab_semua_pembelian" role="tab" aria-controls="tab_semua_pembelian" aria-selected="true">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_belum_dikemas_tab" data-toggle="tab" href="#tab_pembelian_belum_dikemas" role="tab" aria-controls="tab_pembelian_belum_dikemas" aria-selected="false">Perlu Dikemas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_dalam_perjalanan_tab" data-toggle="tab" href="#tab_pembelian_dalam_perjalanan" role="tab" aria-controls="tab_pembelian_dalam_perjalanan" aria-selected="false">Dalam Perjalanan</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_belum_diambil_tab" data-toggle="tab" href="#tab_pembelian_belum_diambil" role="tab" aria-controls="tab_pembelian_belum_diambil" aria-selected="false">Belum Diambil</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_belum_dikonfirmasi_pembeli_tab" data-toggle="tab" href="#tab_pembelian_belum_dikonfirmasi_pembeli" role="tab" aria-controls="tab_pembelian_belum_dikonfirmasi_pembeli" aria-selected="false">Belum Dikonfirmasi Pembeli</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_berhasil_tab" data-toggle="tab" href="#tab_pembelian_berhasil" role="tab" aria-controls="tab_pembelian_berhasil" aria-selected="false">Berhasil [Belum Konfirmasi Pembayaran]</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tab_pembelian_telah_dibayar_tab" data-toggle="tab" href="#tab_pembelian_telah_dibayar" role="tab" aria-controls="tab_pembelian_telah_dibayar" aria-selected="false">Berhasil [Telah Konfirmasi Pembayaran]</a>
                    </li>
                </ul>
                <div class="tab-content tab-content-border" id="tab-content-1">
                    <div class="tab-pane fade show active" id="tab_semua_pembelian" role="tabpanel" aria-labelledby="tab_semua_pembelian_tab">
                        @include('user.toko.tab_semua_pembelian')
                    </div>
                    <div class="tab-pane fade show" id="tab_pembelian_belum_dikemas" role="tabpanel" aria-labelledby="tab_pembelian_belum_dikemas_tab">
                        @include('user.toko.tab_pembelian_belum_dikemas')
                    </div>
                    <div class="tab-pane fade" id="tab_pembelian_dalam_perjalanan" role="tabpanel" aria-labelledby="tab_pembelian_dalam_perjalanan_tab">
                        @include('user.toko.tab_pembelian_dalam_perjalanan')
                    </div>
                    <!-- <div class="tab-pane fade" id="tab_pembelian_belum_diambil" role="tabpanel" aria-labelledby="tab_pembelian_belum_diambil_tab">
                        @include('user.toko.tab_pembelian_belum_diambil')
                    </div> -->
                    <div class="tab-pane fade" id="tab_pembelian_belum_dikonfirmasi_pembeli" role="tabpanel" aria-labelledby="tab_pembelian_belum_dikonfirmasi_pembeli_tab">
                        @include('user.toko.tab_pembelian_belum_dikonfirmasi_pembeli')
                    </div>
                    <div class="tab-pane fade" id="tab_pembelian_berhasil" role="tabpanel" aria-labelledby="tab_pembelian_berhasil_tab">
                        @include('user.toko.tab_pembelian_berhasil')
                    </div>
                    <div class="tab-pane fade" id="tab_pembelian_telah_dibayar" role="tabpanel" aria-labelledby="tab_pembelian_telah_dibayar_tab">
                        @include('user.toko.tab_pembelian_telah_dibayar')
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
                        <a class="nav-link" id="tab_pesanan_jasa_kreatif_on_progress_tab" data-toggle="tab" href="#tab_pesanan_jasa_kreatif_on_progress" role="tab" aria-controls="tab_pesanan_jasa_kreatif_on_progress" aria-selected="true">Dalam Proses</a>
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
                        @include('user.toko.tab_semua_pembelian_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_waiting" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_waiting_tab">
                        @include('user.toko.tab_pembelian_waiting_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_approved" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_approved_tab">
                        @include('user.toko.tab_pembelian_approved_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_on_progress" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_on_progress_tab">
                        @include('user.toko.tab_pembelian_on_progress_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_declined" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_declined_tab">
                        @include('user.toko.tab_pembelian_declined_jasa_kreatif')
                    </div>
                    <div class="tab-pane fade" id="tab_pesanan_jasa_kreatif_done" role="tabpanel" aria-labelledby="tab_pesanan_jasa_kreatif_done_tab">
                        @include('user.toko.tab_pembelian_done_jasa_kreatif')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


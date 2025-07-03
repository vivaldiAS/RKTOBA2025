@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

<!-- <link rel="stylesheet" href="../bootstrap/pesananku_all.css"> -->

@section('container')

    <div class="card-header px-4 py-5">
        <h5 class="text-muted mb-0">Pesanan Anda, <span style="color:#F15743;;">{{ auth()->user()->username }}</span>!</h5>
    </div>

    <div class="card-body p-4">
        <div class="col-md-16">
            <ul class="nav nav-tabs nav-tabs-bg" id="tabs-1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab_semua_pesanan_tab" data-toggle="tab" href="#tab_semua_pesanan"
                        role="tab" aria-controls="tab_semua_pesanan" aria-selected="true">Semua</a>
                </li>
            </ul>
            @foreach ($pesanan as $item)
            <div class="tab-content tab-content-border" id="tab-content-1">
                <div class="tab-pane fade show active" id="tab_semua_pesanan" role="tabpanel"
                    aria-labelledby="tab_semua_pesanan_tab">
                    <div class="card-body p-4">
                        <div class="p-2 card shadow-0 border mb-1">
                            <div class="col-md-12 d-flex justify-content-around" style="margin: 10px 0px -30px 0px">
                                <h5>{{ $item->mobil->nama }}</h5>
                            </div>
                            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                            <a href="./detail_pembelian/">
                                <div class="card border mb-1">
                                    <div class="row" style="padding: 15px 0px 15px 0px; margin: 0px">
                                        <div class="col-md-12" align="center">
                                            <img src="{{ asset('asset/Image/rental_image/' . explode(',',$item->mobil->gambar)[0]) }}" class="img-fluid" alt="Test"
                                                width="200px">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0">Tanggal Pemesanan: {{ $item->tanggal_pemesanan }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0">Tanggal Awal Rental: {{ $item->tanggal_mulai_sewa }}</p>
                                        </div>
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0">Tanggal Akhir Rental: {{ $item->tanggal_akhir_sewa }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0">Jumlah Hari Rental: {{ $item->jumlah_hari_sewa }}</p>
                                        </div>
                                        <div class="col-md-5 d-flex justify-content-center align-items-center">
                                            <p class="text-muted mb-0">Total Harga: {{ $item->total_harga }}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="modal fade" id="batalkan_pembelian_" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="icon-close"></i></span>
                                    </button>

                                    <div class="form-box">
                                        <div class="tab-content" id="tab-content-5">
                                            <div class="tab-pane fade show active">

                                                <label for="isi_review">Apakah anda ingin membatalkan pesanan
                                                    anda?</label><br>
                                                <button type="submit" class="btn btn-outline-primary-2 btn-round"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span>TIDAK</span>
                                                </button>
                                                <button onclick="window.location.href='./batalkan_pembelian/'"
                                                    class="btn btn-primary btn-round" style="float:right">
                                                    <span>KONFIRMASI</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


@endsection

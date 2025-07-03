@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')
<!-- <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab-dashboard-link">
    <p>Hello <span class="font-weight-normal text-dark">User</span> (not <span class="font-weight-normal text-dark">User</span>? <a href="#">Log out</a>) 
    <br>
    From your account dashboard you can view your <a href="#tab-orders" class="tab-trigger-link link-underline">recent orders</a>, manage your <a href="#tab-address" class="tab-trigger-link">shipping and billing addresses</a>, and <a href="#tab-account" class="tab-trigger-link">edit your password and account details</a>.</p>
</div> -->
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-dashboard-link">
    <div class="row">

        <div class="col-lg-4">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="text-muted mb-0"><span style="color: #F15743;">Jumlah Transaksi</span></h5>
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->

            <div class="mb-2"></div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body" align="center" style="padding: 20px 0px 0px 0px">
                            <a style="font-size:15px; font-weight: bold;">Pesanan Sedang Berlangsung</a><br>
                            <a style="font-size:25px;">{{$jumlah_pesanan_sedang_berlangsung}}</a>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body" align="center" style="padding: 20px 0px 0px 0px">
                            <a style="font-size:15px; font-weight: bold;">Pesanan Berhasil</a><br>
                            <a style="font-size:25px;">{{$jumlah_pesanan_berhasil}}</a>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body" align="center" style="padding: 20px 0px 0px 0px">
                            <a style="font-size:15px; font-weight: bold;">Pesanan Dibatalkan</a><br>
                            <a style="font-size:25px;">{{$count_cancelled_purchases}}</a>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
            
        </div><!-- .End .tab-pane -->

        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <h5 class="text-muted mb-0"><span style="color: #F15743;">Pemberitahuan</span></h5>
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
            <div class="mb-2"></div>
            @if($cek_purchases)
                @foreach($purchases as $purchase)
                    <?php
                        $proof_of_payments_tab = DB::table('proof_of_payments')->where('purchase_id', $purchase->purchase_id)->first();
                    ?>
                    @if($purchase->status_pembelian == "status1" || $purchase->status_pembelian == "status1_ambil")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if(!$proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Anda telah memesan</h3>
                                                <p>Pesanan anda telah terkirim dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b>. Silahkan kirim bukti pembayaran agar pesanan anda diproses.</p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                    @if($purchase->status_pembelian == "status1" || $purchase->status_pembelian == "status1_ambil")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if($proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Anda telah mengirim bukti bayar</h3>
                                                <p>Bukti bayar anda dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b> telah terkirim. Silahkan tunggu bukti bayar anda dikonfirmasi.</p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                    @if($purchase->status_pembelian == "status2" || $purchase->status_pembelian == "status2_ambil")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if($proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Pesanan sedang dikemas</h3>
                                                <p>Bukti bayar anda dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b> telah dikonfirmasi. Silahkan tunggu pesanan anda dikemas.</p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                    @if($purchase->status_pembelian == "status3")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if($proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Pesanan sedang dalam perjalanan</h3>
                                                <p>Pesanan anda dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b> sedang dalam perjalanan. Silahkan tunggu pesanan anda sampai. Silahkan konfirmasi jika pesanan anda telah sampai dan telah diterima.</p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                    @if($purchase->status_pembelian == "status3_ambil")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if($proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Pesanan belum diambil</h3>
                                                <p>Silahkan ambil pesanan anda dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b> di toko.</p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                    @if($purchase->status_pembelian == "status4_ambil_a")
                        @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                            @if($proof_of_payments_tab)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card card-dashboard">
                                            <div class="card-body">
                                                <h3 class="card-title">Pesanan telah diambil</h3>
                                                <p>Silahkan konfirmasi pesanan telah anda ambil dari toko dengan kode pembelian <b>{{$purchase->kode_pembelian}}</b></p>
                                                <h4 style="float:right; margin-top: -5px; margin-bottom: -5px"><a href="./detail_pembelian/{{$purchase->purchase_id}}"><i class="icon-long-arrow-right"></i></a></h4>
                                            </div><!-- End .card-body -->
                                        </div><!-- End .card-dashboard -->
                                    </div><!-- End .col-lg-6 -->
                                </div><!-- End .row -->
                            @endif
                        @endif
                    @endif
                @endforeach
            @endif
        </div><!-- .End .tab-pane -->

    </div><!-- End .row -->
</div><!-- .End .tab-pane -->


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


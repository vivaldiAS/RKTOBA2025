@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body" align="center">
                    <p class=""><b>
                        @if($profile->id == $service_booking->user_id)
                            {{$profile->name}} ({{$profile->username}})
                        @endif
                    </b></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->

        <a href="" class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
            <?php
                $service_image = DB::table('service_images')->select('service_image_name')->where('service_images.service_id', $service_booking->service_id)->orderBy('service_image_id', 'asc')->first();
            ?>

            <div class="col-md-2"  align="center">
                <img src="../asset/u_file/service_image/{{$service_image->service_image_name}}" class="img-fluid" alt="{{$service_image->service_image_name}}" width="50px">
            </div>
            
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">{{$service_booking->service_name}}</p>
            </div>

            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">Jumlah: 1</p>
            </div>

            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
            <?php
                if($service_booking->price == null){
                    $harga_produk = "Rp." . number_format(floor($service_booking->price),0,',','.');
                }
                
                else if($service_booking->price != null){
                    $harga_produk = "Rp." . number_format(floor($service_booking->price),0,',','.');
                }
            ?>
            <p class="text-muted mb-0">{{$harga_produk}}</p>
            </div>
        </a>
    
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-dashboard">
                        <div class="card-body">
                        <h3 class="card-title">DESKRIPSI PEMBELIAN </h3>
                            <table>
                                <tr>
                                    <td>Catatan</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td>{{$service_booking->notes}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td>{{$service_booking->address}}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td>{{$service_booking->phone_number}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Mulai</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td>{{ \Carbon\Carbon::parse($service_booking->start_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Selesai</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td>{{ \Carbon\Carbon::parse($service_booking->end_date)->format('d M Y') }}</td>
                                </tr>
                            </table>
                            <p></p>
                        </div><!-- End .card-body -->
                    </div><!-- End .card-dashboard -->
                </div><!-- End .col-lg-6 -->
            </div><!-- End .row -->
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                <div class="row d-flex align-items-center">
                    @if($service_booking->status == "waiting" || $service_booking->status == "approved"
                    || $service_booking->status == "declined" || $service_booking->status == "done")
                        <div class="col-md-12">
                            <div class="d-flex justify-content-around mb-1">
                                @if($service_booking->status == "waiting")
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN MENUNGGU PERSETUJUAN TOKO.</p>
                                @endif

                                @if($service_booking->status == "approved")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN DISETUJUI</p>
                                @endif
                                
                                @if($service_booking->status == "declined")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN DITOLAK.</p>
                                @endif

                                @if($service_booking->status == "done")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN SELESAI.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->

    @if($service_booking->status == "waiting")
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    <a class="btn btn-success" href="/setuju_jasa/{{$service_booking->id}}">Setuju</a>
                    <a class="btn btn-danger" href="/tolak_jasa/{{$service_booking->id}}">Tolak</a>
                </div>
            </div>
        </div>
    </div>
    @endif

</div><!-- .End .tab-pane -->


@endsection


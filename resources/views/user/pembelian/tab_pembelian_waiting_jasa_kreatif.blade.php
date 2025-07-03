@if($cek_service_booking)
    @foreach($service_booking_waiting as $service_book)
        <div class="card-body p-4">
            <div class="p-2 card shadow-0 border mb-1">
                <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                <a href="./detail_pembelian_jasa/{{$service_book->id}}">
                    <div class="card border mb-1">
                        <div class="row" style="padding: 15px 0px 15px 0px; margin: 0px">
                            <div class="col-md-2" align="center">
                                <?php
                                    $service_images = DB::table('service_images')->select('service_image_name')->where('service_id', $service_book->service_id)->orderBy('service_image_id', 'asc')->limit(1)->get();
                                ?>
                                @foreach($service_images as $service_image)
                                    <img src="./asset/u_file/service_image/{{$service_image->service_image_name}}" class="img-fluid" alt="{{$service_book->service_name}}" width ="50px">
                                @endforeach
                            </div>
                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0">{{$service_book->service_name}}</p>
                            </div>

                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0">Jumlah: 1</p>
                            </div>
                            <?php
                                if($service_book->price == null){
                                    $total_harga_produk_fix = "Rp." . number_format(floor($service_book->price),0,',','.');
                                }
                                
                                else if($service_book->price != null){
                                    $total_harga_produk_fix = "Rp." . number_format(floor($service_book->price),0,',','.');
                                }
                            ?>
                            
                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0">{{$total_harga_produk_fix}}</p>
                            </div>

                        </div>
                    </div>
                </a>
                <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                <div class="row d-flex align-items-center">
                    @if($service_book->status == "waiting" || $service_book->status == "approved"
                    || $service_book->status == "declined" || $service_book->status == "done")
                        <div class="col-md-12">
                            <div class="d-flex justify-content-around mb-1">
                                @if($service_book->status == "waiting")
                                <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN MENUNGGU PERSETUJUAN TOKO.</p>
                                @endif

                                @if($service_book->status == "approved")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN DISETUJUI. SILAHKAN LAKUKAN PEMBAYARAN.</p>
                                @endif
                                
                                @if($service_book->status == "declined")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN DITOLAK.</p>
                                @endif

                                @if($service_book->status == "done")
                                    <p class="text-muted mt-1 mb-0 small ms-xl-5">PESANAN SELESAI.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            
                <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                <div class="row d-flex align-items-center">
                    <div class="col-md-12 mb-2">
                        <a class="btn btn-primary btn-round" href="./detail_pembelian_jasa/{{$service_book->id}}">
                            <span>LANJUTKAN</span>
                            <i class="icon-long-arrow-right"></i>
                        </a>
                    </div>
                </div>             
            </div>
        </div>
        
    @endforeach
@else
<div class="col-md-12" align="center">
    <h6 style="color:darkred"><b>Anda Tidak Memiliki Pesanan. <a href="./produk">Ayo Belanja.</a></b></h6>
</div>
@endif
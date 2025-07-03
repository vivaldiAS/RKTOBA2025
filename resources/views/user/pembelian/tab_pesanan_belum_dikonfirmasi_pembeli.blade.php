@if($cek_purchases)
    @foreach($purchases as $purchase)
        @if($purchase->status_pembelian == "status3" || $purchase->status_pembelian == "status4_ambil_a")
            @if($count_proof_of_payment->count_proof_of_payment == 0 || $count_proof_of_payment->count_proof_of_payment != 0)
                <?php
                    $proof_of_payments_tab = DB::table('proof_of_payments')->where('purchase_id', $purchase->purchase_id)->first();
                ?>
                @if($proof_of_payments_tab)
                    <div class="card-body p-4">
                        <div class="p-2 card shadow-0 border mb-1">
                            {{-- <div class="col-md-12 d-flex justify-content-around" style="margin: 10px 0px -30px 0px">
                                <h5>{{$purchase->kode_pembelian}}</h5>
                            </div> --}}
                            
                            <a href="./detail_pembelian/{{$purchase->purchase_id}}">
                                <div class="col-md-12">
                                    @foreach($product_purchases as $product_purchase)
                                        @if($product_purchase->purchase_id == $purchase->purchase_id)
                                        <div class="row box-items">
                                            <div class="column col-4 col-md-3">
                                                <?php
                                                        $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $product_purchase->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                                ?>
                                                @foreach($product_images as $product_image)
                                                    <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" class="img-all" alt="{{$product_purchase->product_name}}" width ="50px">
                                                @endforeach
                                            </div>
                                            <div class="column col-8 col-md-9">
                                                <h5> Belanja {{ date('d-m-Y', strtotime($purchase->created_at)) }}</h5>
                                                <h4 class="mt-1">{{$product_purchase->product_name}}</h4>
                                                <?php
                                                    if($product_purchase->harga_pembelian_produk == null){
                                                        $total_harga_produk_fix = "Rp." . number_format(floor($product_purchase->price * $product_purchase->jumlah_pembelian_produk),0,',','.');
                                                    }
                                                    
                                                    else if($product_purchase->harga_pembelian_produk != null){
                                                        $total_harga_produk_fix = "Rp." . number_format(floor($product_purchase->harga_pembelian_produk),0,',','.');
                                                    }
                                                ?>
                                                <p class="mb-0">
                                                    {{$total_harga_produk_fix}}
                                                </p>
                                                <p class="text-muted mb-0">Jumlah: {{$product_purchase->jumlah_pembelian_produk}}</p>
                                            </div>
                                            <div class="col col-3">
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </a>

                            {{-- <a href="./detail_pembelian/{{$purchase->purchase_id}}">
                                @foreach($product_purchases as $product_purchase)
                                    @if($product_purchase->purchase_id == $purchase->purchase_id)
                                    <div class="card border mb-1">
                                        <div class="row" style="padding: 15px 0px 15px 0px; margin: 0px">
                                            <div class="col-md-2" align="center">
                                                <?php
                                                    $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $product_purchase->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                                ?>
                                                @foreach($product_images as $product_image)
                                                    <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" class="img-fluid" alt="{{$product_purchase->product_name}}" width ="50px">
                                                @endforeach
                                            </div>
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0">{{$product_purchase->product_name}}</p>
                                            </div>
                                            <?php
                                                $jumlah_product_specifications = DB::table('product_specifications')->where('product_id', $product_purchase->product_id)->count();
                                            ?>
                                            @if($jumlah_product_specifications == 0)

                                            @else
                                                @foreach($product_specifications as $product_specification)
                                                    @if($product_specification->product_id == $product_purchase->product_id)
                                                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                        <p class="text-muted mb-0">{{$product_specification->nama_spesifikasi}}</p>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0">Jumlah: {{$product_purchase->jumlah_pembelian_produk}}</p>
                                            </div>
                                            <?php
                                                if($product_purchase->harga_pembelian_produk == null){
                                                    $total_harga_produk_fix = "Rp." . number_format(floor($product_purchase->price * $product_purchase->jumlah_pembelian_produk),0,',','.');
                                                }
                                                
                                                else if($product_purchase->harga_pembelian_produk != null){
                                                    $total_harga_produk_fix = "Rp." . number_format(floor($product_purchase->harga_pembelian_produk),0,',','.');
                                                }
                                            ?>
                                            
                                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                                <p class="text-muted mb-0">{{$total_harga_produk_fix}}</p>
                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </a> --}}
                            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                            <div class="row d-flex align-items-center">
                                @if($purchase->status_pembelian == "status4" || $purchase->status_pembelian == "status4_ambil_b"
                                || $purchase->status_pembelian == "status5" || $purchase->status_pembelian == "status5_ambil")
                                    <div class="col-md-12 mb-1">
                                        <p class="text-muted ">Jejak Pembelian</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="progress" style="height: 6px; border-radius: 16px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 100%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-around mb-1">
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Pesanan Diterima. PEMBELIAN BERHASIL.</p>
                                        </div>
                                    </div>
                                @endif

                                @if($purchase->status_pembelian == "status3" || $purchase->status_pembelian == "status3_ambil"
                                || $purchase->status_pembelian == "status4_ambil_a")
                                    <div class="col-md-12 mb-1">
                                        <p class="text-muted ">Jejak Pembelian</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="progress" style="height: 6px; border-radius: 16px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 66.6%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-around mb-1">
                                            @if($purchase->status_pembelian == "status3")
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN SAMPAI.</p>
                                            @endif

                                            @if($purchase->status_pembelian == "status3_ambil")
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">SILAHKAN AMBIL PESANAN ANDA DI TOKO.</p>
                                            @endif
                                            
                                            @if($purchase->status_pembelian == "status4_ambil_a")
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Pesanan telah diberikan. SILAHKAN KONFIRMASI PESANAN.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($purchase->status_pembelian == "status2" || $purchase->status_pembelian == "status2_ambil")
                                    <div class="col-md-12 mb-1">
                                        <p class="text-muted ">Jejak Pembelian</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="progress" style="height: 6px; border-radius: 16px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: 33.3%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="d-flex justify-content-around mb-1">
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Pesanan Sedang Diproses. TUNGGU PESANAN DIPROSES.</p>
                                        </div>
                                    </div>
                                @endif

                                @if($purchase->status_pembelian == "status1" || $purchase->status_pembelian == "status1_ambil")
                                <div class="col-md-12 mb-1">
                                    <p class="text-muted ">Jejak Pembelian</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="progress" style="height: 6px; border-radius: 16px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: 0%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <div class="d-flex justify-content-around mb-1">
                                        @if($count_proof_of_payment->count_proof_of_payment == 0)
                                            <p class="text-muted mt-1 mb-0 small ms-xl-5">Belum dapat dikonfirmasi. KIRIM BUKTI PEMBAYARAN.</p>
                                        @endif
                                        
                                        <?php
                                            $proof_of_payments = DB::table('proof_of_payments')->where('purchase_id', $purchase->purchase_id)->first();
                                        ?>
                                        @if($count_proof_of_payment->count_proof_of_payment != 0)
                                            @if($proof_of_payments)
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Bukti pembayaran telah dikirim. MENUNGGU KONFIRMASI.</p>
                                            @else
                                                <p class="text-muted mt-1 mb-0 small ms-xl-5">Belum dapat dikonfirmasi. KIRIM BUKTI PEMBAYARAN.</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        
                            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
                            <div class="row d-flex align-items-center">
                                <div class="col-md-12 mb-2">
                                    <a href="./detail_pembelian/{{$purchase->purchase_id}}">
                                        <div class="btns btns-red">
                                            <span>Lanjutkan</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </div>
                                    </a>
                                    @if($purchase->status_pembelian == "status1" || $purchase->status_pembelian == "status1_ambil")
                                        @if($count_proof_of_payment->count_proof_of_payment != 0)
                                            @if($proof_of_payments)
                                            
                                            @else
                                            <a href="#batalkan_pembelian_{{$purchase->purchase_id}}" class="btn btn-outline-dark btn-rounded" data-toggle="modal" href="" style="float:right">
                                                <span>BATALKAN</span>
                                            </a>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                @endif
            @endif
        @endif

        <div class="modal fade" id="batalkan_pembelian_{{$purchase->purchase_id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="icon-close"></i></span>
                        </button>

                        <div class="form-box">
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active">
                                    
                                    <label for="isi_review">Apakah anda ingin membatalkan pesanan anda? *</label><br>
                                    <button type="submit" class="btn btn-outline-primary-2 btn-round" data-dismiss="modal" aria-label="Close">
                                        <span>TIDAK</span>
                                    </button>
                                    <button onclick="window.location.href='./batalkan_pembelian/{{$purchase->purchase_id}}'" class="btn btn-primary btn-round" style="float:right">
                                        <span>KONFIRMASI</span>
                                    </button>
                                </div>
                            </div>
                        </div>
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
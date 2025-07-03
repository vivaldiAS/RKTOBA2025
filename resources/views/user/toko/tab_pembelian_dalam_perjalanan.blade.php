@foreach($purchases as $purchase)
    @if($purchase->status_pembelian == "status3")
    <div class="card-body p-4">
        <div class="p-2 card shadow-0 border mb-1">
            <div class="col-md-12 d-flex justify-content-around" style="margin: 10px 0px -30px 0px">
                <h5>
                    @if($purchase->kode_pembelian == "")

                    @else
                        {{$purchase->kode_pembelian}} - 
                    @endif
                    {{$purchase->name}} ({{$purchase->username}})
                </h5>
            </div>
            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
            <a href="./detail_pembelian/{{$purchase->purchase_id}}">
                @foreach($product_purchases as $product_purchase)
                    @if($product_purchase->purchase_id == $purchase->purchase_id)
                    <div class="card border mb-1">
                        <div class="row" style="padding: 15px 0px 15px 0px; margin: 0px">
                            <div class="col-md-2" align="center">
                                <?php
                                    $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $product_purchase->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                ?>
                                @foreach($product_images as $product_image)
                                    <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" class="img-fluid" alt="{{$product_purchase->product_name}}" width="50px">
                                @endforeach
                            </div>
                            
                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <h5> Belanja {{ date('d-m-Y', strtotime($purchase->created_at)) }}</h5>
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
                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <?php
                                    if($product_purchase->harga_pembelian_produk == null){
                                        $harga_produk = "Rp." . number_format(floor($product_purchase->price * $product_purchase->jumlah_pembelian_produk),0,',','.');
                                    }
                                    
                                    else if($product_purchase->harga_pembelian_produk != null){
                                        $harga_produk = "Rp." . number_format(floor($product_purchase->harga_pembelian_produk),0,',','.');
                                    }
                                ?>
                                <p class="text-muted mb-0">{{$harga_produk}}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </a>
            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
            <div class="row d-flex align-items-center">
                @if($purchase->status_pembelian == "status5" || $purchase->status_pembelian == "status5_ambil")
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
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Penjualan Telah Dibayar. PENJUALAN BERHASIL.</p>
                    </div>
                </div>
                @endif

                @if($purchase->status_pembelian == "status4" || $purchase->status_pembelian == "status4_ambil_b")
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
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Pembelian Berhasil. SILAHKAN TUNGGU BAYARAN.</p>
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
                        style="width: 33.3%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-around mb-1">
                        @if($purchase->status_pembelian == "status3")
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN DITERIMA.</p>
                        @endif

                        @if($purchase->status_pembelian == "status3_ambil")
                            <p class="text-muted mt-1 mb-0 small ms-xl-5">SILAHKAN TUNGGU PELANGGAN MENGAMBIL PESANAN</p>
                        @endif
                        
                        @if($purchase->status_pembelian == "status4_ambil_a")
                            <p class="text-muted mt-1 mb-0 small ms-xl-5">TUNGGU PELANGGAN MENGKONFIRMASI PESANAN YANG TELAH DIAMBIL.</p>
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
                        style="width: 0%; border-radius: 16px; background-color: #F15743;" aria-valuenow="65"
                        aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-around mb-1">
                        <p class="text-muted mt-1 mb-0 small ms-xl-5">Ada Pesanan. SILAHKAN PROSES PESANAN.</p>
                    </div>
                </div>
                @endif

                @if($purchase->status_pembelian == "status1")
                
                @endif
            </div>

            <hr class="mb-2" style="background-color: #e0e0e0; opacity: 1;">
            <div class="row d-flex align-items-center">
                <div class="col-md-12 mb-2">
                    <a class="btn btn-primary btn-round" href="./detail_pembelian/{{$purchase->purchase_id}}">
                        <span>LANJUTKAN</span>
                        <i class="icon-long-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
    @endif
@endforeach

@if($jumlah_purchases == 0)
    <div class="col-md-12" align="center">
        <h6 style="color:darkred"><b>Anda Tidak Memiliki Pembelian</b></h6>
    </div>
@endif

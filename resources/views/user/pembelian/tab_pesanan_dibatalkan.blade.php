@if($cek_purchases)
    @foreach($cancelled_purchases as $purchase)
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
                            </div>
                            @endif
                        @endforeach
                    </div>
                </a>
                
                {{-- <div>
                    @foreach($product_purchases as $product_purchase)
                        @if($product_purchase->purchase_id == $purchase->purchase_id)
                        <div class="card border mb-1">
                            <a href="../lihat_produk/{{$product_purchase->product_id}}" class="row" style="padding: 15px 0px 15px 0px; margin: 0px">
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
                            </a>
                        </div>
                        @endif
                    @endforeach
                </div> --}}
            </div>
        </div>
    @endforeach
@else
<div class="col-md-12" align="center">
    <h6 style="color:darkred"><b>Anda Tidak Memiliki Pesanan. <a href="./produk">Ayo Belanja.</a></b></h6>
</div>
@endif
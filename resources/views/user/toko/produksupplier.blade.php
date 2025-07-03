@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Tambahkan produk grosir anda</p>
    <a class="nav-link btn btn-outline-primary-2" href="./tambah_produk_supplier/pilih_kategori">
        <span>TAMBAH PRODUK GROSIR</span>
        <i class="icon-long-arrow-right"></i>
    </a>

    <div class="mb-4"></div>

    <div class="tab-content">
        <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="products">
                <div class="row justify-content-center">

                    @foreach($products as $products)
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="product product-11 text-center">
                            <figure class="product-media">
                                <a href="./edit_produk_supplier/{{$products->product_id}}">
                                    <?php
                                        $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $products->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                        $product_images_hover = DB::table('product_images')->select('product_image_name')->where('product_id', $products->product_id)->orderBy('product_image_id', 'desc')->limit(1)->get();
                                    ?>
                                    @foreach($product_images as $product_image)
                                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="Product image" class="product-image">
                                    @endforeach
                                    
                                    @foreach($product_images_hover as $product_image_hover)
                                        <img src="./asset/u_file/product_image/{{$product_image_hover->product_image_name}}" alt="Product image" class="product-image-hover">
                                    @endforeach
                                </a>
                            </figure><!-- End .product-media -->

                            <div class="">
                                <div class="mb-1"></div>

                                <div class="product-cat">
                                    <a href="#">{{$products->nama_kategori}}</a>
                                </div><!-- End .product-cat -->
                                
                                <div class="mb-1"></div>
                                
                                <!-- <hr style="margin:0px; border-top:1px solid grant; "> -->
                                
                                <div class="mb-1"></div>

                                <h3 class="product-title"><a href="./edit_produk_supplier/{{$products->product_id}}">{{$products->product_name}}</a></h3><!-- End .product-title -->
                                
                                <div class="mb-1"></div>

                                <div class="product-price">
                                    <?php
                                        $harga_produk = "Rp " . number_format($products->price,0,',','.');     
                                        echo $harga_produk
                                    ?>
                                </div><!-- End .product-price -->
                            </div><!-- End .product-body -->
                        </div><!-- End .product -->
                    </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                    @endforeach

                </div><!-- End .row -->
            </div><!-- End .products -->
        </div><!-- .End .tab-pane -->
    </div><!-- .End .tab-content -->
</div><!-- .End .tab-pane -->

@endsection


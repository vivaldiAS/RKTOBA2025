@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>
    /* .intro-slider-container{
        width:80%;
    }
    .intro-slider-container, .intro-slide{
        height:300px;
    } */
    
    
    @media screen and (min-width: 200px) { .intro-slider-container { max-height:50px; } }
    
    @media screen and (min-width: 325px) { .intro-slider-container { max-height:80px; }}

    @media screen and (min-width: 450px) { .intro-slider-container { max-height:110px; }}
    
    @media screen and (min-width: 575px) { .intro-slider-container { max-height:140px; }}
    
    @media screen and (min-width: 700px) { .intro-slider-container { max-height:170px; } }

    @media screen and (min-width: 825px) { .intro-slider-container { max-height:195px; } }
    
    @media screen and (min-width: 950px) { .intro-slider-container { max-height:230px; } }

    @media screen and (min-width: 1075px) { .intro-slider-container { max-height:260px; } }

    @media screen and (min-width: 1200px) { .intro-slider-container { max-height:290px; } }
</style>

@section('container')

<main class="main">
    <center>
    <div class="intro-slider-container" style="width:92%; height:290px">
        <div class="owl-carousel owl-simple owl-light owl-nav-inside" data-toggle="owl" data-owl-options='{"nav": false}'>
            <!-- <div class="intro-slide" style="background-image: url({{ URL::asset('asset/Molla/assets/images/demos/demo-2/slider/slide-1.jpg') }}); height:300px">
                <a href="./" class="container intro-content" style="height:100%"></a>
            </div> -->

            {{-- @foreach($carousels as $carousels)
            <div class="intro-slide" style="background-image: url('./asset/u_file/carousel_image/{{$carousels->carousel_image}}'); height:100%">
                @if($carousels->open_in_new_tab == 1)
                    @if($carousels->link_carousel == "")
                        <a href="#" target="_blank" class="container intro-content" style="height:100%"></a>
                    @endif

                    @if($cek_http)
                        <a href="{{$carousels->link_carousel}}" target="_blank" class="container intro-content" style="height:100%"></a>
                    @elseif($cek_www)
                        <a href="https://{{$carousels->link_carousel}}" target="_blank" class="container intro-content" style="height:100%"></a>
                    @else
                        <a href="https://{{$carousels->link_carousel}}" target="_blank" class="container intro-content" style="height:100%"></a>
                    @endif
                @elseif($carousels->open_in_new_tab == 0)
                    @if($carousels->link_carousel == "")
                        <a href="#" class="container intro-content" style="height:100%"></a>
                    @endif

                    @if($cek_http)
                        <a href="{{$carousels->link_carousel}}" class="container intro-content" style="height:100%"></a>
                    @elseif($cek_www)
                        <a href="https://{{$carousels->link_carousel}}" class="container intro-content" style="height:100%"></a>
                    @else
                        <a href="https://{{$carousels->link_carousel}}" class="container intro-content" style="height:100%"></a>
                    @endif
                @endif
            </div><!-- End .intro-slide -->
            @endforeach --}}

        </div><!-- End .owl-carousel owl-simple -->
        <span class="slider-loader text-white"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->
    </center>

    <!-- <div class="brands-border owl-carousel owl-simple" data-toggle="owl" 
        data-owl-options='{
            "nav": false, 
            "dots": false,
            "margin": 0,
            "loop": false,
            "responsive": {
                "0": {
                    "items":2
                },
                "420": {
                    "items":3
                },
                "600": {
                    "items":4
                },
                "900": {
                    "items":5
                },
                "1024": {
                    "items":6
                },
                "1360": {
                    "items":7
                }
            }
        }'>
        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/1.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/2.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/3.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/4.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/5.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/6.png') }}" alt="Brand Name">
        </a>

        <a href="#" class="brand">
            <img src="{{ URL::asset('asset/Molla/assets/images/brands/7.png') }}" alt="Brand Name">
        </a>
    </div> -->
    <!-- End .owl-carousel -->

    <!-- <div class="mb-3 mb-lg-5"></div> -->
    <!-- End .mb-3 mb-lg-5 -->

    <div class="mb-3"></div>
    <!-- End .mb-6 -->

    <!-- <div class="container">
        <ul class="nav nav-pills nav-border-anim nav-big justify-content-center mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="products-featured-link" data-toggle="tab" href="#products-featured-tab" role="tab" aria-controls="products-featured-tab" aria-selected="true">Featured</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="products-sale-link" data-toggle="tab" href="#products-sale-tab" role="tab" aria-controls="products-sale-tab" aria-selected="false">On Sale</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="products-top-link" data-toggle="tab" href="#products-top-tab" role="tab" aria-controls="products-top-tab" aria-selected="false">Top Rated</a>
            </li>
        </ul>
    </div>

    <div class="container-fluid">
        <div class="tab-content tab-content-carousel">
            <div class="tab-pane p-0 fade show active" id="products-featured-tab" role="tabpanel" aria-labelledby="products-featured-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":5
                            },
                            "1600": {
                                "items":6,
                                "nav": true
                            }
                        }
                    }'>

                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-1-1.jpg') }}" alt="Product image" class="product-image">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-1-2.jpg') }}" alt="Product image" class="product-image-hover">
                            </a>

                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <h3 class="product-title"><a href="product.html">Butler Stool Ladder</a></h3>
                            <div class="product-price">
                                $251,00
                            </div>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="tab-pane p-0 fade" id="products-sale-tab" role="tabpanel" aria-labelledby="products-sale-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":5
                            },
                            "1600": {
                                "items":6,
                                "nav": true
                            }
                        }
                    }'>

                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            <a href="product.html">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-5-1.jpg') }}" alt="Product image" class="product-image">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-5-2.jpg') }}" alt="Product image" class="product-image-hover">
                            </a>

                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <h3 class="product-title"><a href="product.html">Petite Table Lamp</a></h3>
                            <div class="product-price">
                                $675,00
                            </div>

                            <div class="product-nav product-nav-dots">
                                <a href="#" class="active" style="background: #74543e;"><span class="sr-only">Color name</span></a>
                                <a href="#" style="background: #e8e8e8;"><span class="sr-only">Color name</span></a>
                            </div>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="tab-pane p-0 fade" id="products-top-tab" role="tabpanel" aria-labelledby="products-top-link">
                <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                    data-owl-options='{
                        "nav": false, 
                        "dots": true,
                        "margin": 20,
                        "loop": false,
                        "responsive": {
                            "0": {
                                "items":2
                            },
                            "480": {
                                "items":2
                            },
                            "768": {
                                "items":3
                            },
                            "992": {
                                "items":4
                            },
                            "1200": {
                                "items":5
                            },
                            "1600": {
                                "items":6,
                                "nav": true
                            }
                        }
                    }'>

                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            <span class="product-label label-circle label-new">New</span>
                            <a href="product.html">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-3-1.jpg') }}" alt="Product image" class="product-image">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-3-2.jpg') }}" alt="Product image" class="product-image-hover">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <h3 class="product-title"><a href="product.html">Flow Slim Armchair</a></h3>
                            <div class="product-price">
                                $970,00
                            </div>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                        </div>
                    </div>

                    <div class="product product-11 text-center">
                        <figure class="product-media">
                            <span class="product-label label-circle label-sale">Sale</span>
                            <a href="product.html">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-4-1.jpg') }}" alt="Product image" class="product-image">
                                <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-4-2.jpg') }}" alt="Product image" class="product-image-hover">
                            </a>
                            <div class="product-action-vertical">
                                <a href="#" class="btn-product-icon btn-wishlist"><span>add to wishlist</span></a>
                            </div>
                        </figure>

                        <div class="product-body">
                            <h3 class="product-title"><a href="product.html">Roots Sofa Bed</a></h3>
                            <div class="product-price">
                                <span class="new-price">$337,00</span>
                                <span class="old-price">Was $449,00</span>
                            </div>

                            <div class="product-nav product-nav-dots">
                                <a href="#" class="active" style="background: #878883;"><span class="sr-only">Color name</span></a>
                                <a href="#" style="background: #dfd5c2;"><span class="sr-only">Color name</span></a>
                            </div>
                        </div>
                        <div class="product-action">
                            <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="mb-5"></div> -->
    <!-- End .mb-5 -->

    <!-- <div class="mb-6"></div> -->
    <!-- End .mb-6 -->



    <div class="container">
            <h5 class="">Pencarian Saat Ini</h5>
            <div class="row">
              <div class="card col-md-3">
                Museum Balige
              </div>
              <div class="col-md-3 card">
                Museum Balige
              </div>
              <div class="col-md-3 card">
                Kolam Renang Balige
              </div>
              <div class="col-md-3 card">
                Kolam Renang Balige
              </div>

            </div>
        {{-- <div class="heading heading-center mb-1">
            @if($count_products->count_products == 0)

            @else
            <h2 class="title">Produk Terlaris</h2><!-- End .title -->
            @endif

            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist"> --}}
                <!-- <li class="nav-item">
                    <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab" aria-controls="top-all-tab" aria-selected="true">All</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" id="top-fur-link" data-toggle="tab" href="#top-fur-tab" role="tab" aria-controls="top-fur-tab" aria-selected="false">Furniture</a>
                </li> -->
            {{-- </ul> --}}
        {{-- </div><!-- End .heading --> --}}
        
        {{-- <div class="tab-content">
            <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                <div class="products"> --}}
                    {{-- <div class="row"> --}}
                        {{-- <h3 class="ml-5">Pencarian Saat Ini</h3> --}}

                        {{-- <div class="col-6 col-md-4 col-lg-4 col-xl-5col card">
                            <p>dada</p> 
                        </div> --}}
                        {{-- @foreach($total_penjualan_produk as $total_penjualan_produk)
                        <?php
                            // $produk_terlaris = DB::table('products')->where('product_id', $total_penjualan_produk->product_id)
                            // ->join('categories', 'products.category_id', '=', 'categories.category_id')
                            // ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->get();
                        ?>
                            @foreach($produk_terlaris as $produk_terlaris)
                            <div class="col-6 col-md-4 col-lg-4 col-xl-5col">
                                <div class="product product-11 text-center">
                                    <figure class="product-media">
                                        <a href="./lihat_produk/{{$produk_terlaris->product_id}}">
                                            <?php
                                                $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $produk_terlaris->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                                $product_images_hover = DB::table('product_images')->select('product_image_name')->where('product_id', $produk_terlaris->product_id)->orderBy('product_image_id', 'desc')->limit(1)->get();
                                            ?>
                                            @foreach($product_images as $product_image)
                                                <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$produk_terlaris->product_name}}" class="product-image">
                                            @endforeach
                                            
                                            @foreach($product_images_hover as $product_image_hover)
                                                <img src="./asset/u_file/product_image/{{$product_image_hover->product_image_name}}" alt="{{$produk_terlaris->product_name}}" class="product-image-hover">
                                            @endforeach
                                        </a>
                                    </figure><!-- End .product-media -->

                                    <div class="">
                                        <div class="mb-1"></div>

                                        <div class="product-cat">
                                            <a href="./produk/kategori[{{$produk_terlaris->category_id}}]">{{$produk_terlaris->nama_kategori}}</a>
                                        </div><!-- End .product-cat -->
                                        
                                        <!-- <div class="mb-1"></div> -->
                                        
                                        <!-- <hr style="margin:0px; border-top:1px solid grant; "> -->
                                        
                                        <div class="mb-1"></div>

                                        <div class="product-cat">
                                            <a href="./produk/toko[{{$produk_terlaris->merchant_id}}]"><b>{{$produk_terlaris->nama_merchant}}</b></a>
                                        </div><!-- End .product-cat -->
                                        
                                        <div class="mb-1"></div>

                                        <h3 class="product-title"><a href="./lihat_produk/{{$produk_terlaris->product_id}}">{{$produk_terlaris->product_name}}</a></h3><!-- End .product-title -->
                                        
                                        <div class="mb-1"></div>

                                        <div class="product-price">
                                            <?php
                                                // $harga_produk = "Rp " . number_format($produk_terlaris->price,0,',','.');     
                                                // echo $harga_produk 
                                                ?>
                                        </div><!-- End .product-price -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                            @endforeach
                        @endforeach --}}

                   
    </div><!-- End .container -->

    <div class="mb-9"></div>

    <div class="container">
        <h5 class="">Pilihan Tiket Wisata</h5>
        <div class="row">
            <br>
            <div class="col-md-9">
                <p style="color: black;">Silahkan pilih tiket wisata sesuai dengan keinginan anda. <br>
                    Kami menyediakan tiket wisata terbaru pada masa kini</p>
              </div>
              <div class="col">
                <a href=""  class="btn btn-light"> Lihat Semua</a>
              </div>
            </div>
        <div class="row">
          <div class="card col-md-3">
            Museum Balige
          </div>
          <div class="col-md-3 card">
            Museum Balige
          </div>
          <div class="col-md-3 card">
            Kolam Renang Balige
          </div>
          <div class="col-md-3 card">
            Kolam Renang Balige
          </div>

        </div>
    </div>

    <div class="mb-9"></div>

    <div class="container">
        <h5 class="">Pilihan Tiket Wisata</h5>
        <div class="row">
            <br>
            <div class="col-md-9">
                <p style="color: black;">Pergi ke  tempat baru untuk mendapatkan pengalaman?  Kamu bisa mendapatkan pengalaman baru dengan mengunjungi tempat wisata ini.</p>
              </div>
              <div class="col">
                <a href=""  class="btn btn-light"> Lihat Semua</a>
              </div>
            </div>
        <div class="row">
          <div class="card col-md-3">
            Museum Balige
          </div>
          <div class="col-md-3 card">
            Museum Balige
          </div>
          <div class="col-md-3 card">
            Kolam Renang Balige
          </div>
          <div class="col-md-3 card">
            Kolam Renang Balige
          </div>

        </div>
    </div>
    
    <div class="mb-3"></div>

    <div class="container">
        <div class="heading heading-center mb-1">
            {{-- @if($count_products->count_products == 0)

            @else
            <h2 class="title">Produk Terbaru</h2><!-- End .title -->
            @endif

            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                <!-- <li class="nav-item">
                    <a class="nav-link active" id="top-all-link" data-toggle="tab" href="#top-all-tab" role="tab" aria-controls="top-all-tab" aria-selected="true">All</a>
                </li> -->
                <!-- <li class="nav-item">
                    <a class="nav-link" id="top-fur-link" data-toggle="tab" href="#top-fur-tab" role="tab" aria-controls="top-fur-tab" aria-selected="false">Furniture</a>
                </li> -->
            </ul>
        </div><!-- End .heading -->

        <div class="tab-content">
            <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
                <div class="products">
                    <div class="row justify-content-center">

                        @foreach($products as $products)
                        <div class="col-6 col-md-4 col-lg-4 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="./lihat_produk/{{$products->product_id}}">
                                        <?php
                                            // $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $products->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                            // $product_images_hover = DB::table('product_images')->select('product_image_name')->where('product_id', $products->product_id)->orderBy('product_image_id', 'desc')->limit(1)->get();
                                        ?>
                                        @foreach($product_images as $product_image)
                                            <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$products->product_name}}" class="product-image">
                                        @endforeach
                                        
                                        @foreach($product_images_hover as $product_image_hover)
                                            <img src="./asset/u_file/product_image/{{$product_image_hover->product_image_name}}" alt="{{$products->product_name}}" class="product-image-hover">
                                        @endforeach
                                    </a>
                                </figure><!-- End .product-media -->

                                <div class="">
                                    <div class="mb-1"></div>

                                    <div class="product-cat">
                                        <a href="./produk/kategori[{{$products->category_id}}]">{{$products->nama_kategori}}</a>
                                    </div><!-- End .product-cat -->
                                    
                                    <!-- <div class="mb-1"></div> -->
                                    
                                    <!-- <hr style="margin:0px; border-top:1px solid grant; "> -->
                                    
                                    <div class="mb-1"></div>

                                    <div class="product-cat">
                                        <a href="./produk/toko[{{$products->merchant_id}}]"><b>{{$products->nama_merchant}}</b></a>
                                    </div><!-- End .product-cat -->
                                    
                                    <div class="mb-1"></div>

                                    <h3 class="product-title"><a href="./lihat_produk/{{$products->product_id}}">{{$products->product_name}}</a></h3><!-- End .product-title -->
                                    
                                    <div class="mb-1"></div>

                                    <div class="product-price">
                                        <?php
                                            // $harga_produk = "Rp " . number_format($products->price,0,',','.');     
                                            // echo $harga_produk
                                        ?>
                                    </div><!-- End .product-price -->
                                </div><!-- End .product-body -->
                            </div><!-- End .product -->
                        </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                        @endforeach --}}

                    </div><!-- End .row -->
                </div><!-- End .products -->
            </div><!-- .End .tab-pane -->
            
            <!-- <div class="tab-pane p-0 fade" id="top-fur-tab" role="tabpanel" aria-labelledby="top-fur-link">
                <div class="products">
                    <div class="row justify-content-center">
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <span class="product-label label-circle label-sale">Sale</span>
                                    <a href="product.html">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-9-1.jpg') }}" alt="Product image" class="product-image">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-9-2.jpg') }}" alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
                                    </div>
                                </figure>

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#">Furniture</a>
                                    </div>
                                    <h3 class="product-title"><a href="product.html">Garden Armchair</a></h3>
                                    <div class="product-price">
                                        <span class="new-price">$94,00</span>
                                        <span class="old-price">Was $94,00</span>
                                    </div>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <span class="product-label label-circle label-new">New</span>
                                    <a href="product.html">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-12-1.jpg') }}" alt="Product image" class="product-image">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-12-2.jpg') }}" alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
                                    </div>
                                </figure>

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#">Furniture</a>
                                    </div>
                                    <h3 class="product-title"><a href="product.html">2-Seater</a></h3>
                                    <div class="product-price">
                                        $3.107,00
                                    </div>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 col-md-4 col-lg-3 col-xl-5col">
                            <div class="product product-11 text-center">
                                <figure class="product-media">
                                    <a href="product.html">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-13-1.jpg') }}" alt="Product image" class="product-image">
                                        <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/products/product-13-2.jpg') }}" alt="Product image" class="product-image-hover">
                                    </a>

                                    <div class="product-action-vertical">
                                        <a href="#" class="btn-product-icon btn-wishlist "><span>add to wishlist</span></a>
                                    </div>
                                </figure>

                                <div class="product-body">
                                    <div class="product-cat">
                                        <a href="#">Furniture</a>
                                    </div>
                                    <h3 class="product-title"><a href="product.html">Wingback Chair</a></h3>
                                    <div class="product-price">
                                        $2.486,00
                                    </div>
                                </div>
                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div><!-- End .tab-content -->
    </div><!-- End .container -->

    <div class="container">
        <hr class="mt-1 mb-6">
    </div><!-- End .container -->
    
    <!-- <div class="blog-posts">
        <div class="container">
            <h2 class="title text-center">From Our Blog</h2>

            <div class="owl-carousel owl-simple carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "items": 3,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
                        },
                        "600": {
                            "items":2
                        },
                        "992": {
                            "items":3
                        }
                    }
                }'>
                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/blog/post-1.jpg') }}" alt="image desc">
                        </a>
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Nov 22, 2018</a>, 0 Comments
                        </div>
                        <h3 class="entry-title">
                            <a href="single.html">Sed adipiscing ornare.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Continue Reading</a>
                        </div>
                    </div>
                </article>
            
                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/blog/post-2.jpg') }}" alt="image desc">
                        </a>
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 12, 2018</a>, 0 Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="single.html">Fusce lacinia arcuet nulla.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Continue Reading</a>
                        </div>
                    </div>
                </article>

                <article class="entry entry-display">
                    <figure class="entry-media">
                        <a href="single.html">
                            <img src="{{ URL::asset('asset/Molla/assets/images/demos/demo-2/blog/post-3.jpg') }}" alt="image desc">
                        </a>
                    </figure>

                    <div class="entry-body text-center">
                        <div class="entry-meta">
                            <a href="#">Dec 19, 2018</a>, 2 Comments
                        </div>

                        <h3 class="entry-title">
                            <a href="single.html">Quisque volutpat mattis eros.</a>
                        </h3>

                        <div class="entry-content">
                            <a href="single.html" class="read-more">Continue Reading</a>
                        </div>
                    </div>
                </article>
            </div>

            <div class="more-container text-center mt-2">
                <a href="blog.html" class="btn btn-outline-darker btn-more"><span>View more articles</span><i class="icon-long-arrow-right"></i></a>
            </div>
        </div>
    </div> -->
    
</main><!-- End .main -->





@endsection
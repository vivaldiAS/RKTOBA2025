@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>

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
            
            @foreach($carousels as $carousels)
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
            @endforeach

        </div><!-- End .owl-carousel owl-simple -->
        <span class="slider-loader text-white"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->
    </center>
    <div class= "product-landing-categories container">
    <div class="heading heading-left mb-1">
        <h5 class="title">Kategori</h5>
    </div>
        <section id="category" class="section-p1 my-3">
            @foreach ($categories as $item)
            <div class ="fe-box">
                <a href="{{ url($item['url']) }}">
                    <img class="category-img" src = "{{ URL::asset($item['icon_image']) }}" alt="" loading="lazy">
                    <h6>{{ $item['name'] }}</h6>
                </a>
                </div>
            @endforeach
        </section>
    </div>

    <section id="product1" class="container">
        @if($count_product->count_product == 0)
            <h2 class="title" align="center">Makanan dan Minuman Terfavorite Untukmu</h2>
        @else
            <div class="heading heading-left mb-1">
                <h2 class="title">Makanan dan Minuman Terfavorite Untukmu</h2>
            </div>
            <div class="pro-container">
            @foreach($produk_makanan_minuman_terlaris as $produk_makanan_minuman_terlaris)
                {{-- {{ var_dump($produk_makanan_minuman_terlaris) }} --}}
                <div class="pro ">
                @if ($produk_makanan_minuman_terlaris->type == 'supplier')
                    <a href="./lihat_produk_supplier/{{$produk_makanan_minuman_terlaris->product_id}}">
                @else
                    <a href="./lihat_produk/{{$produk_makanan_minuman_terlaris->product_id}}">
                @endif
                    <?php
                    $product_images = DB::table('product_images')
                        ->select('product_image_name')
                        ->where(
                            'product_id',
                            $produk_makanan_minuman_terlaris->product_id
                        )
                        ->orderBy('product_image_id', 'asc')
                        ->limit(1)
                        ->get();
                    $product_images_hover = DB::table('product_images')
                        ->select('product_image_name')
                        ->where(
                            'product_id',
                            $produk_makanan_minuman_terlaris->product_id
                        )
                        ->orderBy('product_image_id', 'desc')
                        ->limit(1)
                        ->get();
                    ?>
                    @foreach($product_images as $product_image)
                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$produk_makanan_minuman_terlaris->product_name}}" loading="lazy">
                    @endforeach
                </a>
                    <div class="description">
                        <p class="product-title"><a href="./lihat_produk/{{$produk_makanan_minuman_terlaris->product_id}}">{{$produk_makanan_minuman_terlaris->product_name}}</a></p>  
                        <?php $harga_produk =
                            "Rp " .
                            number_format(
                                $produk_makanan_minuman_terlaris->price,
                                0,
                                ',',
                                '.'
                            ); ?>
                        <h4 class="product-price">{{$harga_produk}}</h4>
                        <h4 class="product-cat">{{ $produk_makanan_minuman_terlaris->subdistrict_name }}</h4>
                        <p class="sold-item">Terjual {{$produk_makanan_minuman_terlaris->count_product_purchases}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <div class="mb-3"></div>

        <section id="product1" class="container">
            <div class="heading heading-left mb-1">
                <h2 class="title">Pakaian Paling Diminati</h2>
            </div>
            <div class="pro-container">
            @foreach($produk_pakaian_terlaris as $produk_pakaian_terlaris)
                <div class="pro ">
                @if ($produk_pakaian_terlaris->type == 'supplier')
                    <a href="./lihat_produk_supplier/{{$produk_pakaian_terlaris->product_id}}">
                @else
                    <a href="./lihat_produk/{{$produk_pakaian_terlaris->product_id}}">
                @endif
                    <?php
                    $product_images = DB::table('product_images')
                        ->select('product_image_name')
                        ->where(
                            'product_id',
                            $produk_pakaian_terlaris->product_id
                        )
                        ->orderBy('product_image_id', 'asc')
                        ->limit(1)
                        ->get();
                    $product_images_hover = DB::table('product_images')
                        ->select('product_image_name')
                        ->where(
                            'product_id',
                            $produk_pakaian_terlaris->product_id
                        )
                        ->orderBy('product_image_id', 'desc')
                        ->limit(1)
                        ->get();
                    ?>
                    @foreach($product_images as $product_image)
                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$produk_pakaian_terlaris->product_name}}">
                    @endforeach
                </a>
                    <div class="description">
                        <p class="product-title"><a href="./lihat_produk/{{$produk_pakaian_terlaris->product_id}}">{{$produk_pakaian_terlaris->product_name}}</a></p>           
                        <?php $harga_produk =
                            "Rp " .
                            number_format(
                                $produk_pakaian_terlaris->price,
                                0,
                                ',',
                                '.'
                            ); ?>
                        <h4 class="product-price">{{$harga_produk}}</h4>
                        <h4 class="product-cat">{{ $produk_pakaian_terlaris->subdistrict_name }}</h4>
                        <p class="sold-item">Terjual {{$produk_pakaian_terlaris->count_product_purchases}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <div class="mb-3"></div>

        <section id="product1" class="container">
            <div class="heading heading-left mb-1">
                <h2 class="title">Produk Terbaru</h2>
            </div>
            <div class="pro-container">
            @foreach($new_products as $products)
                <div class="pro ">
                @if ($products->type == 'supplier')
                    <a href="./lihat_produk_supplier/{{$products->product_id}}">
                @else
                    <a href="./lihat_produk/{{$products->product_id}}">
                @endif
                <?php
                $product_images = DB::table('product_images')
                    ->select('product_image_name')
                    ->where('product_id', $products->product_id)
                    ->orderBy('product_image_id', 'asc')
                    ->limit(1)
                    ->get();
                $product_images_hover = DB::table('product_images')
                    ->select('product_image_name')
                    ->where('product_id', $products->product_id)
                    ->orderBy('product_image_id', 'desc')
                    ->limit(1)
                    ->get();
                ?>
                    @foreach($product_images as $product_image)
                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$products->product_name}}" loading="lazy" class="product-image">
                    @endforeach
                </a>
                    <div class="description">
                        <p class="product-title"><a href="./lihat_produk/{{$products->product_id}}">{{$products->product_name}}</a></p>          
                        <?php
                        $harga_produk =
                            "Rp " .
                            number_format($products->price, 0, ',', '.');

                        $cek_penjualan = DB::table('product_purchases')
                            ->where('product_id', $products->product_id)
                            ->groupBy('product_id')
                            ->count();

                        if ($cek_penjualan != 0) {
                            $penjualan_produk_terbaru = DB::table(
                                'product_purchases'
                            )
                                ->select(
                                    DB::raw(
                                        'SUM(jumlah_pembelian_produk) as count_product_purchases'
                                    ),
                                    'product_id'
                                )
                                ->where('product_id', $products->product_id)
                                ->groupBy('product_id')
                                ->first();

                            $total_jual_produk_terbaru =
                                $penjualan_produk_terbaru->count_product_purchases;
                        } else {
                            $total_jual_produk_terbaru = 0;
                        }
                        ?>
                        <h4 class="product-price">{{$harga_produk}}</h4>
                        <h4 class="product-cat">{{ $products->subdistrict_name }}</h4>
                        @if($total_jual_produk_terbaru == 0)

                        @else
                            <p class="sold-item">Terjual {{$total_jual_produk_terbaru}}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    @endif
</main>

@endsection


@section('js')
    @include('user.layout.use_script_chatbot')

    <!-- Usability Testing Maze -->
    <script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection
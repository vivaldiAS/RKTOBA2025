@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<style>
    .intro-slider-container, .intro-slide{
        height:300px;
    }

    #product2 .pro{
        width:19%;
        min-width:150px;
        border: 0.5px solid #fafafa ;
        box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.02);
        border-radius: 10px;
        cursor:pointer;
        margin: 15px 0;
        transition: 0.2s ease;
        position: relative;
    }
    #product2 .pro:hover{
        box-shadow: 20px 20px 30px rgba(0, 0, 0, 0.06);
    }
    #product2 .pro .description{
        text-align: start;
        padding-top: 10px 3px;
    }
    #product2 .pro-container{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    #product2 .pro img{
        width: 100%;
        border-radius: 10px 10px 0px 0px;
        height: 200px;
        object-fit: cover;
        padding-bottom:0.625rem;
    }
    .sold-item{
        color: #F15743;
        font-size:10px;
    }
    .collapse.show{
        visibility: visible;
    }
</style>

@section('container')
<main class="main">
    <div class="bg-light" style="background-image: url('asset/Molla/assets/images/page-header-bg.jpg')">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container d-flex align-items-center">
                @if($kategori_produk_id > 0)
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/produk') }}">Produk</a></li>
                        <li class="breadcrumb-item">Kategori</li>
                        <li class="breadcrumb-item active">{{$nama_kategori->nama_kategori}}</li>
                    </ol>
                @else
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{ url('/produk') }}">Produk</a></li>
                    </ol>
                @endif
            </div>
        </nav>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <aside class="col-lg-3 order-lg-first">
                    <div class="sidebar sidebar-shop">

                        <div class="widget widget-collapsible mt-5">
                            <h3 class="widget-title">
                                <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
                                    Kategori
                                </a>
                            </h3><!-- End .widget-title -->

                            <div class="collapse show" id="widget-1">
                                <div class="widget-body">
                                    <div class="filter-items filter-items-count">
                                        @foreach($categories as $category)
                                        <div class="filter-item">
                                            <label for="cat-1"><a href="../../produk/kategori[{{$category->category_id}}]">{{$category->nama_kategori}}</a></label>

                                            <!-- <span class="item-count">3</span> -->
                                        </div>
                                        @endforeach
                                        <div class="filter-item">
                                            <label for="cat-1"><a href="../../produksupplier">Produk Grosir</a></label>
                                        </div>
                                    </div><!-- End .filter-items -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .collapse -->
                        </div><!-- End .widget -->
                    </div><!-- End .sidebar sidebar-shop -->
                </aside><!-- End .col-lg-3 -->
                <div class="col-lg-9 mt-3">
                    <div class="toolbox">
                        <div class="toolbox-right">
                            <div class="toolbox-sort">
                                <label for="sortby">Filter:</label>
                                <div class="select-custom">
                                    <select name="sortby" id="sortby" class="form-control">
                                        <option value="highest_price" >Harga Tertinggi</option>
                                        <option value="lowest_price">Harga Terendah</option>
                                        <option value="no_filter" selected="selected">Tidak ada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .toolbox -->

                    @if($toko_ditemukan > 0)
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                <span>TOKO ({{$toko_ditemukan}})</span>
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->
                    </div><!-- End .toolbox -->
                    <div class="products mb-3">
                        <div class="row justify-content-center">
                        @foreach($toko as $toko)
                            <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                                <div class="product product-11 text-center">
                                    <div class="">
                                        <h3 class="product-title"><a href="../../produk/toko[{{$toko->merchant_id}}]">{{$toko->nama_merchant}}</a></h3><!-- End .product-title -->
                                    </div><!-- End .product-body -->
                                </div><!-- End .product -->
                            </div><!-- End .col-sm-6 col-md-4 col-lg-3 -->
                        @endforeach
                        </div><!-- End .row -->
                    </div><!-- End .products -->
                    <hr>
                    @endif
                    @if($toko_ditemukan == 0)
                    <div class="product product-11 text-center">
                        <div class="">
                            <h3 class="product-title">Tidak ada toko ditemukan.</a></h3><!-- End .product-title -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <hr>
                    @endif

                    @if($produk_ditemukan == 0)
                    <div class="product product-11 text-center">
                        <div class="">
                            <h3 class="product-title">Tidak ada produk ditemukan.</a></h3><!-- End .product-title -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                    <hr>
                    @endif
                    @if($produk_ditemukan > 0)
                    <div class="toolbox">
                        <div class="toolbox-left">
                            <div class="toolbox-info">
                                <span>PRODUK ({{$produk_ditemukan}})</span>
                            </div><!-- End .toolbox-info -->
                        </div><!-- End .toolbox-left -->
                    </div><!-- End .toolbox -->
                    @endif

                    <section id="product1" class="container-product">
                        <div class="pro-container" id="show_product">
                        @foreach($products as $product)
                            <div class="pro">
                                <a href="../../lihat_produk/{{$product->product_id}}">
                                    <?php
                                    $product_images = DB::table('product_images')
                                        ->select('product_image_name')
                                        ->where('product_id', $product->product_id)
                                        ->orderBy('product_image_id', 'asc')
                                        ->limit(1)
                                        ->get();
                                    ?>
                                    @foreach($product_images as $product_image)
                                        <img src="../../asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$product->product_name}}" loading="lazy" >
                                    @endforeach

                                </a>
                                <div class="description">
                                    <p class="product-title"><a href="../../lihat_produk/{{$product->product_id}}">{{$product->product_name}}</a></p>
                                    <?php
                                        $harga_produk = "Rp " . number_format($product->price, 0, ',', '.');

                                        $cek_penjualan = DB::table('product_purchases')
                                        ->where('product_id', $product->product_id)
                                        ->groupBy('product_id')->count();

                                        if($cek_penjualan != 0){
                                            $penjualan_produk_terbaru = DB::table('product_purchases')
                                            ->select(DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'), 'product_id')
                                            ->where('product_id', $product->product_id)
                                            ->groupBy('product_id')->first();

                                            $total_terjual = $penjualan_produk_terbaru->count_product_purchases;
                                        }

                                        else{
                                            $total_terjual = 0;
                                        }
                                    ?>
                                    <h4 class="product-price">{{$harga_produk}}</h4>
                                    <h4 class="product-cat">{{ $product->subdistrict_name }}</h4>
                                    @if($total_terjual == 0)

                                    @else
                                        <p class="sold-item">Terjual {{$total_terjual}}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </section>

                   {{$products->links('user.more_button')}}

                </div><!-- End .col-lg-9 -->
            </div><!-- End .row -->
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ URL::asset('asset/js/function_3.js') }}"></script>

<script>
    $kategori_produk_id = <?php echo (int)$kategori_produk_id ?>;
    $produk_ditemukan = <?php echo (int)$produk_ditemukan ?>;

    <?php if($produk_ditemukan >=0){?>
        $cari = '<?php echo $cari ?>';
    <?php }?>

    $merchant_id = <?php echo (int)$merchant_id ?>;

</script>

@endsection


@section('js')
    @include('user.layout.use_script_chatbot')
    
    <!-- Usability Testing Maze -->
    <script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection

@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<style>
    .intro-slider-container, .intro-slide{
        height:300px;
    }

    .rating{
        position: absolute;
        /* top:50%; */
        left: 50%;
        transform: translate(-50%, -50%) rotateY(180deg);
        display: flex;
    }

    .rating input{
        display: none;
    }

    .rating label{
        display: block;
        cursor: pointer;
        width: 30px;
        /*background: #ccc;*/
    }

    .rating label:before{
        content:'\f005';
        font-family: fontAwesome;
        position: relative;
        display: block;
        font-size: 30px;
        color: #101010;
    }

    .rating label:after{
        content:'\f005';
        font-family: fontAwesome;
        position: absolute;
        display: block;
        font-size: 30px;
        color: #ffc107;
        top:0;
        opacity: 0;
        transition: .5s;
    }

    .rating label:hover:after,
    .rating label:hover ~ label:after,
    .rating input:checked ~ label:after
    {
        opacity: 1;
    }

</style>

<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('container')

<main class="main">
    <div class="page-content">
        <div class="product-details-top">
            <div class="bg-light pb-5 mb-4">
                <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                    <div class="container d-flex align-items-center">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/produk') }}">Produk</a></li>
                            <li class="breadcrumb-item">Kategori</li>
                            <li class="breadcrumb-item active"></li>
                        </ol>

                        <!-- <nav class="product-pager ml-auto" aria-label="Product">
                            <a class="product-pager-link product-pager-prev" href="#" aria-label="Previous" tabindex="-1">
                                <i class="icon-angle-left"></i>
                                <span>Prev</span>
                            </a>

                            <a class="product-pager-link product-pager-next" href="#" aria-label="Next" tabindex="-1">
                                <span>Next</span>
                                <i class="icon-angle-right"></i>
                            </a>
                        </nav> -->
                    </div>
                </nav>
                <div class="container">
                    <div class="product-gallery-carousel owl-carousel owl-full owl-nav-dark">
                        @foreach($service_images as $service_image)
                            @if($service_image->service_id == $services->service_id)
                            <figure class="product-gallery-image">
                                <img src="../asset/u_file/service_image/{{$service_image->service_image_name}}" data-zoom-image="../asset/u_file/service_image/{{$service_image->service_image_name}}" alt="product image">
                            </figure>
                            @endif
                        @endforeach

                        <!-- <figure class="product-gallery-image">
                            <img src="{{ URL::asset('asset/Molla/assets/images/products/single/gallery/2.jpg') }}" data-zoom-image="{{ URL::asset('asset/Molla/assets/images/products/single/gallery/2-big.jpg') }}" alt="product image">
                        </figure> -->

                    </div>
                </div>
            </div>

                <div class="product-details product-details-centered product-details-separator">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-cat">
                                    <a href="../produk/toko[{{$services->merchant_id}}]"><b>{{$services->nama_merchant}}</b></a>
                                </div><!-- End .product-cat -->
                                
                                <div class="mb-2"></div>
                                
                                <h1 class="product-title">{{$services->service_name}}</h1>

                                <!-- <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link" id="review-link">( 2 Reviews )</a>
                                </div> -->

                                <div class="product-price">
                                    <?php
                                        $harga_produk = "Rp " . number_format($services->price,0,',','.');     
                                        echo $harga_produk
                                    ?>
                                </div>

                                <div class="details-filter-row details-row-size mb-md-1">
                                    <div class="product-cat">
                                        <span>Sub Kategori:</span>
                                        <a href="../produk/kategori[{{$services->sub_category_id}}]">{{$services->nama_sub_kategori}}</a>
                                    </div><!-- End .product-cat -->
                                    <span class="meta-separator">|</span>
                                </div><!-- End .entry-meta -->
                            </div>

                            <div class="col-md-6">

                                <form action="../masuk_keranjang_beli_jasa/{{$services->service_id}}" method="post" enctype="multipart/form-data">
                                @csrf
                                    <div class="product-details-action">
                                        <div class="details-action-col">
                                            <button type="submit" class="btn btn-primary"><span>BELI SEKARANG</span></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div class="container">
            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Deskripsi</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab" role="tab" aria-controls="product-info-tab" aria-selected="false">Additional information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="product-info_toko-link" data-toggle="tab" href="#product-info_toko-tab" role="tab" aria-controls="product-info_toko-tab" aria-selected="false">Informasi Toko</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                        {{$services->service_description}}
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade" id="product-info-tab" role="tabpanel" aria-labelledby="product-info-link">
                        <div class="product-desc-content">
                            <h3>Information</h3>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. </p>

                            <h3>Fabric & care</h3>
                            <ul>
                                <li>Faux suede fabric</li>
                                <li>Gold tone metal hoop handles.</li>
                                <li>RI branding</li>
                                <li>Snake print trim interior </li>
                                <li>Adjustable cross body strap</li>
                                <li> Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop: 61cm</li>
                            </ul>

                            <h3>Size</h3>
                            <p>one size</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery information</a><br>
                            We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns information</a></p>
                        </div>
                    </div> -->
                    <div class="tab-pane fade" id="product-info_toko-tab" role="tabpanel" aria-labelledby="product-info_toko-link">
                        <div class="product-info_toko-content">
                            <table>
                                <tr>
                                    <td>Nama Toko</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td colspan="3">{{$services->nama_merchant}}</td>
                                </tr>
                                <tr>
                                    <td>Deskripsi Toko</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td colspan="3">{{$services->deskripsi_toko}}</td>
                                </tr>
                                @if($cek_merchant_address > 0 )
                                <tr>
                                    <td rowspan="4">Lokasi Toko</td>
                                    <td rowspan="4">&emsp; : &emsp;</td>
                                    <td>Provinsi</td>
                                    <td>&emsp; : &emsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td>Kota</td>
                                    <td>&emsp; : &emsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>&emsp; : &emsp;</td>
                                    
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td> {{$merchant_address->merchant_street_address}} </td>
                                </tr>
                                @elseif($cek_merchant_address == 0 )
                                
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container">
            <h2 class="title text-center mb-4">Produk Lain yang Serupa</h2>
            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" 
                data-owl-options='{
                    "nav": false, 
                    "dots": true,
                    "margin": 20,
                    "loop": false,
                    "responsive": {
                        "0": {
                            "items":1
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
                            "items":4,
                            "nav": true,
                            "dots": false
                        }
                    }
                }'>
                
                <?php
                    $nama_produk = explode(" ", $services->service_name);
                    $cek_produk_serupa = 0; 
                ?>

                @foreach($nama_produk as $get_nama_produk)
                <?php
                    // $cek_jumlah_produk_serupa = DB::table('products')->where('is_deleted', 0)->where('product_name', 'like', "%".$get_nama_produk."%")
                    // ->where('product_id', '!=', $product->product_id)->first();

                    $produk_serupa = DB::table('services')->where('is_deleted', 0)->where('service_name', 'like', "%".$get_nama_produk."%")
                    ->where('service_id', '!=', $services->service_id)->join('sub_categories', 'services.sub_category_id', '=', 'sub_categories.id')
                    ->join('merchants', 'services.merchant_id', '=', 'merchants.merchant_id')->orderBy('service_id', 'desc')->limit(5)->get();

                ?>
                    @foreach($produk_serupa as $produk_serupa)
                        @if($cek_produk_serupa == $produk_serupa->service_id)

                        @elseif($cek_produk_serupa != $produk_serupa->service_id)
                        <?php $cek_produk_serupa = $produk_serupa->service_id; ?>
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <!-- <span class="product-label label-new">New</span> -->
                            
                                <a href="../lihat_jasa_kreatif/{{$produk_serupa->service_id}}">
                                    <?php
                                        $product_images = DB::table('service_images')->select('service_image_name')->where('service_id', $produk_serupa->service_id)->orderBy('service_image_id', 'asc')->limit(1)->get();
                                        $product_images_hover = DB::table('service_images')->select('service_image_name')->where('service_id', $produk_serupa->service_id)->orderBy('service_image_id', 'desc')->limit(1)->get();
                                    ?>
                                    @foreach($product_images as $product_image)
                                        <img src="../asset/u_file/service_image/{{$product_image->service_image_name}}" alt="{{$produk_serupa->service_name}}" class="product-image">
                                    @endforeach
                                    
                                    @foreach($product_images_hover as $product_image_hover)
                                        <img src="../asset/u_file/service_image/{{$product_image_hover->service_image_name}}" alt="{{$produk_serupa->service_name}}" class="product-image-hover">
                                    @endforeach
                                </a>
                                <!-- <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                    <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                    <a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                </div>

                                <div class="product-action">
                                    <a href="#" class="btn-product btn-cart"><span>add to cart</span></a>
                                </div> -->
                            </figure>

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="../produk/kategori[{{$produk_serupa->category_id}}]">{{$produk_serupa->nama_sub_kategori}}</a>
                                </div>

                                <div class="mb-1"></div>

                                <div class="product-cat">
                                    <a href="../produk/toko[{{$produk_serupa->merchant_id}}]"><b>{{$produk_serupa->nama_merchant}}</b></a>
                                </div><!-- End .product-cat -->
                                
                                <div class="mb-1"></div>

                                <h3 class="product-title"><a href="../lihat_jasa_kreatif/{{$produk_serupa->service_id}}">{{$produk_serupa->service_name}}</a></h3>

                                <div class="mb-1"></div>

                                <div class="product-price">
                                    <?php
                                        $harga_produk = "Rp " . number_format($produk_serupa->price,0,',','.');     
                                        echo $harga_produk
                                    ?>
                                </div>
                                <!-- <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 20%;"></div>
                                    </div>
                                    <span class="ratings-text">( 2 Reviews )</span>
                                </div> -->

                            </div>
                        </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="rate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <div class="tab-content" id="tab-content-5">
                        <div class="tab-pane fade show active">
                            <form action="../PostTinjauan/{{$services->service_id}}" method="post">
                            @csrf
                                <div class="rating">
                                    <input type="radio" name="nilai_review" id="star1-modal" value="5"><label for="star1"></label>
                                    <input type="radio" name="nilai_review" id="star2-modal" value="4"><label for="star2"></label>
                                    <input type="radio" name="nilai_review" id="star3-modal" value="3"><label for="star3"></label>
                                    <input type="radio" name="nilai_review" id="star4-modal" value="2"><label for="star4"></label>
                                    <input type="radio" name="nilai_review" id="star5-modal" value="1"><label for="star5"></label>
                                </div><br>
                                
                                <div class="form-group">
                                    <label for="isi_review">Isi Tinjauan *</label>
                                    <input type="text" class="form-control" id="isi_review" name="isi_review" placeholder="Berikan pendapat Anda" required>
                                </div><!-- End .form-group -->

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2 btn-round">
                                        <span>KIRIM</span>
                                    </button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- .End .tab-pane -->
                    </div><!-- End .tab-content -->
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->

<div class="modal fade" id="pemberitahuan_alamat_toko" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <h5>Mohon maaf. <br><br> Anda tidak dapat membeli dari toko ini dikarenakan toko belum memasukkan alamat.</h5>
                </div><!-- End .form-box -->
            </div><!-- End .modal-body -->
        </div><!-- End .modal-content -->
    </div><!-- End .modal-dialog -->
</div><!-- End .modal -->

<div class="modal fade" id="tambah_produk_keranjang_modal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <h5>Produk telah ditambahkan ke keranjang.</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_produk_keinginan_modal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <h5>Produk telah ditambahkan ke daftar keinginan.</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hapus_produk_keinginan_modal" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="icon-close"></i></span>
                </button>

                <div class="form-box">
                    <h5>Produk telah dihapus dari daftar keinginan.</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    <?php
        if($cek_merchant_address > 0){
    ?>
    $merchant_address_id = <?php echo $merchant_address->merchant_address_id?>
    <?php
        }
    ?>

</script>
<script src="{{ URL::asset('asset/js/function_2.js') }}"></script>

@endsection
@extends('user/layout/main')

@section('title', 'Rumah Kreatif Toba')

<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/lihat_produk.css') }}">
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
.img-serupa{
width: 100%;
border-radius: 10px 10px 0px 0px;
height: 250px;
object-fit: cover;
padding-bottom:0.625rem;
display: flex;
flex-wrap: wrap;
}
.product-text{
    color: #425466;
    font-weight: 400;
    font-size: 15px;
    line-height: 24px;
    padding-top: 5px;
}

</style>

<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('container')

<main class="main">
    <div class="page-content">
        <div class="product-details-top">
            <div class="bg-light  mb-4">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container d-flex align-items-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/produksupplier') }}">Produk Grosir</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$product->product_name}}</li>
                    </ol>
                </div>
            </nav>
            </div>
            </div>
        <div class="container">
            <div class="d-flex mt-5 flex-md-row flex-column">
                <div class="image-preview col-12 col-md-4">
                    <div class="preview">
                        <div class="holder-big-preview d-flex justify-content-center">
                            <div class="big-preview shadow-sm">
                                <img  id="big-preview" src="{{ asset('asset/u_file/product_image/'. $product_images[0]->product_image_name) }}" alt="">
                            </div>
                        </div>
                        <div class="wrap-preview-item" id="wrap-preview-item">
                            <div class="list-preview mt-1 d-flex flex-row justify-center">
                                @foreach($product_images as $product_image)
                                <div class="list-image shadow-sm" role="button">
                                    <img src="{{ asset('asset/u_file/product_image/'. $product_image->product_image_name) }}"  alt="">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="info-product col-12 col-md-5 mt-5 mt-md-0">
                    <div class="product-name">
                        <h4>{{ $product->product_name}}</h4>
                    </div>
                    <div>
                        <span class="sold">Transaksi Terjual {{ $total_terjual }}</span>
                        <h3 class="price mt-">Rp. {{ number_format($product->price,2, ",", ".") }}</h3>
                    </div>
                    <div class="mt-3">
                        <div class="border-info-v2">
                            <span class="info-primary">Detail</span>
                        </div>
                        <div class="description">
                            <p class="product-text">Berat Satuan : {{ $product->heavy }} Kg</p>
                            <p class="product-text">Kategori : {{ $product->nama_kategori }}</p>
                            <p class="product-text">{{ $product->product_description }}</p>
                        </div>
                    </div>
                    <a href="/produk_supplier/toko[{{$product->merchant_id}}]">
                        <div class="mt-3 border-info-v2 d-flex gap-3 align-items-start py-3">
                            <div class="icon-store mr-3">
                                <img src="{{ asset('asset/image/store_icon.png') }}" alt="">
                            </div>
                            <div class="d-flex gap-3 flex-column">
                                <span class="info-primary">{{ $product->nama_merchant }}</span>
                                <span class="text-secondary">{{ $lokasi_toko['city'].','.$lokasi_toko['subdistrict_name'] }}</span>
                            </div>
                        </div>
                    </a>
                    <div class="border-info-v2 d-flex flex-column without-top d-flex gap-3 align-items-start py-3">
                        <span class="fs-6 font-weight-bold">Pengiriman</span>
                        <div class="sender-location d-flex gap-3">
                            <img src="{{ asset('asset/image/location.png') }}" alt="location">
                            <span class="">{{  $lokasi_toko['city'].','.$lokasi_toko['subdistrict_name'] }}</span>
                        </div>
                        <div class="sender-location d-flex gap-3">
                            <img src="{{ asset('asset/image/truk.png') }}" alt="location">
                            <span class="">Kurir tersedia : Pos Indonesia, JNE</span>
                        </div>
                    </div>
                </div>
                <div class="purchase-detail col-12 col-md-4 mt-5 mt-md-0">
                    <div class="shadow-sm rounded px-3 py-3  ">
                        <p class="fs-4 text-black font-weight-black">Pembelian</p>
                        <div class="d-flex mt-2 justify-content-center align-items-center">
                            <div class="col-6">
                                <div class="input-custom">
                                    <i class="fa fa-minus" id="quantity-decrement" role="button" onclick="kurang_jumlah()"></i>
                                    <input name="quantity" id="quantity" value="0" disabled>
                                    <i class="fa fa-plus" data-max="{{ $stocks->stok }}" role="button" id="quantity-increment" onclick="tambah_jumlah()"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                Stok tersisa {{ $stocks->stok }}
                            </div>
                        </div>

                        <script>
                            function tambah_jumlah()
                            {
                                var jumlah_dipasang  = document.getElementById("quantity").value;
                                document.getElementById('jumlah_dipasang').value = parseInt(1) + parseInt(jumlah_dipasang);
                            }
                            
                            function kurang_jumlah()
                            {
                                var jumlah_dipasang  = document.getElementById("quantity").value;
                                document.getElementById('jumlah_dipasang').value = parseInt(jumlah_dipasang) - parseInt(1);
                            }
                        </script>

                        @if(Auth::check())
                            @if(!$merchant_address)

                            @elseif($cek_alamat)
                                <div class="purchase-option">
                                    <input type="checkbox" id="tambah_produk_keranjang" name="tambah_produk_keranjang" value="{{$product->product_id}}" hidden>
                                    <label class="btns btns-outline" for="tambah_produk_keranjang">
                                        +Keranjang
                                    </label>

                                    <form action="../masuk_keranjang_beli/{{$product->product_id}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <input name="jumlah_pembelian_produk" type="number" id="jumlah_dipasang" hidden>
                                        <button class="btns btns-red">
                                            Beli Sekarang
                                        </button>
                                    </form>
                                </div>
                            @else
                                <form action="../alamat" method="get" enctype="multipart/form-data">
                                @csrf
                                    <input type="number" name="product" value="{{$product->product_id}}" hidden>
                                    <div class="purchase-option">
                                        <button class="btns btns-outline">
                                            +Keranjang
                                        </button>
                                        <button class="btns btns-red">
                                            Beli Sekarang
                                        </button>
                                    </div>
                                </form>
                            @endif

                            <div class="buyerSubAction">
                                <a href="../chat/{{$product->merchant_id}}">
                                    <div class="buyerSubActiona">
                                        <img src="{{ asset('asset/image/chat.svg') }}" alt="">
                                        <span class="labelSub">Chat</span>
                                    </div>
                                </a>
                                
                                <div id="div_tambah_hapus_produk_keinginan">
                                    @if(!$cek_wishlist)
                                        <input type="checkbox" id="tambah_produk_keinginan" name="tambah_produk_keinginan" value="{{$product->product_id}}" hidden>
                                        <label id="label_tambah_produk_keinginan" class="buyerSubActionb" for="tambah_produk_keinginan">
                                            <img src="{{ asset('asset/image/heartOutline.svg') }}" alt="">
                                            <span class="labelSub">Wishlist</span>
                                        </label>

                                        <input type="checkbox" id="hapus_produk_keinginan" name="hapus_produk_keinginan" value="{{$product->product_id}}" hidden>
                                        <label id="label_hapus_produk_keinginan" class="buyerSubActionb" for="hapus_produk_keinginan">
                                            <img src="{{ asset('asset/image/fullHeart.svg') }}" alt="">
                                            <span class="labelSub">Wishlist</span>
                                        </label>

                                    @elseif($cek_wishlist)
                                        <input type="checkbox" id="hapus_produk_keinginan" name="hapus_produk_keinginan" value="{{$product->product_id}}" hidden>
                                        <label id="label_hapus_produk_keinginan" class="buyerSubActionb" for="hapus_produk_keinginan">
                                            <img src="{{ asset('asset/image/fullHeart.svg') }}" alt="">
                                            <span class="labelSub">Wishlist</span>
                                        </label>

                                        <input type="checkbox" id="tambah_produk_keinginan" name="tambah_produk_keinginan" value="{{$product->product_id}}" hidden>
                                        <label id="label_tambah_produk_keinginan" class="buyerSubActionb" for="tambah_produk_keinginan">
                                            <img src="{{ asset('asset/image/heartOutline.svg') }}" alt="">
                                            <span class="labelSub">Wishlist</span>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        
                        @else           
                            <div class="purchase-option">
                                <a href="#signin-modal" class="btns btns-outline" data-toggle="modal">
                                    +Keranjang
                                </a>
                                <a href="#signin-modal" class="btns btns-red" data-toggle="modal">
                                    Beli Sekarang
                                </a>
                            </div> 
                            
                            <div class="buyerSubAction">
                                <a href="#signin-modal" class="buyerSubActiona" data-toggle="modal">
                                    <img src="{{ asset('asset/image/chat.svg') }}" alt="">
                                    <span class="labelSub">Chat</span>
                                </a>
                                
                                <a href="#signin-modal"  class="buyerSubActionb" data-toggle="modal">
                                    <img src="{{ asset('asset/image/heartOutline.svg') }}" alt="">
                                    <span class="labelSub">Wishlist</span>
                                </a>
                            </div>
                        @endif
                        
                        <div class="d-flex">
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <section class="container">
            <div class="reviews mt-5">
                <h2 class="mb-4">Ulasan Pengguna:</h2>
                <!-- <h3>Reviews</h3> -->
                @foreach($reviews as $reviews)
                <div class="review">
                    <div class="row no-gutters">
                        <div class="col-auto">
                            <h4><a href="#">{{$reviews->name}}</a></h4>
                            <div class=" ratings-container">
                                <div class="ratings">
                                    @if($reviews->nilai_review == 5)
                                    <div class="ratings-val" style="width: 100%;"></div>
                                    @elseif($reviews->nilai_review == 4)
                                    <div class="ratings-val" style="width: 80%;"></div>
                                    @elseif($reviews->nilai_review == 3)
                                    <div class="ratings-val" style="width: 60%;"></div>
                                    @elseif($reviews->nilai_review == 2)
                                    <div class="ratings-val" style="width: 40%;"></div>
                                    @elseif($reviews->nilai_review == 1)
                                    <div class="ratings-val" style="width: 20%;"></div>
                                    @endif
                                </div>
                            </div>
                            <!-- <span class="review-date">6 days ago</span> -->
                        </div>
                        <div class="col">

                            <div class="review-content">
                                <p>{{$reviews->isi_review}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="review">
                    <div class="row no-gutters">
                        
                        @if(Auth::check())
                            @if(!$cek_review)
                            <div class="rating  mb-4">
                                <input type="radio" id="star1" onclick="rate5()"><label for="star1"></label>
                                <input type="radio" id="star2" onclick="rate4()"><label for="star2"></label>
                                <input type="radio" id="star3" onclick="rate3()"><label for="star3"></label>
                                <input type="radio" id="star4" onclick="rate2()"><label for="star4"></label>
                                <input type="radio" id="star5" onclick="rate1()"><label for="star5"></label>
                            </div>
                            <script>
                                function rate1() {
                                    $("#rate").modal();
                                    document.getElementById("star5-modal").checked = true;
                                }
                                function rate2() {
                                    $("#rate").modal();
                                    document.getElementById("star4-modal").checked = true;
                                }
                                function rate3() {
                                    $("#rate").modal();
                                    document.getElementById("star3-modal").checked = true;
                                }
                                function rate4() {
                                    $("#rate").modal();
                                    document.getElementById("star2-modal").checked = true;
                                }
                                function rate5() {
                                    $("#rate").modal();
                                    document.getElementById("star1-modal").checked = true;
                                }
                            </script>
                            @else

                            @endif
                        @else

                        @endif
                    </div>
                </div>
            </div>
        </section>
        <div class="container">
            <h2 class="title text-center mb-2 mt-5">Produk Lain yang Serupa</h2>
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
                $nama_produk = explode(" ", $product->product_name);
                $cek_produk_serupa = 0;
                ?>

                @foreach($nama_produk as $get_nama_produk)
                <?php $produk_serupa = DB::table('products')
                    ->where('is_deleted', 0)
                    ->where(
                        'product_name',
                        'like',
                        "%" . $get_nama_produk . "%"
                    )
                    ->where('product_id', '!=', $product->product_id)
                    ->join(
                        'categories',
                        'products.category_id',
                        '=',
                        'categories.category_id'
                    )
                    ->where('categories.type', 'supplier')
                    ->join(
                        'merchants',
                        'products.merchant_id',
                        '=',
                        'merchants.merchant_id'
                    )
                    ->orderBy('product_id', 'desc')
                    ->limit(5)
                    ->get(); ?>
                    @foreach($produk_serupa as $produk_serupa)
                        @if($cek_produk_serupa == $produk_serupa->product_id)

                        @elseif($cek_produk_serupa != $produk_serupa->product_id)
                        <?php $cek_produk_serupa =
                            $produk_serupa->product_id; ?>
                        <div class="product product-7 text-center">
                            <figure class="product-media">
                                <!-- <span class="product-label label-new">New</span> -->
                            
                                <a href="../lihat_produk_supplier/{{$produk_serupa->product_id}}">
                                    <?php
                                    $product_images = DB::table(
                                        'product_images'
                                    )
                                        ->select('product_image_name')
                                        ->where(
                                            'product_id',
                                            $produk_serupa->product_id
                                        )
                                        ->orderBy('product_image_id', 'asc')
                                        ->limit(1)
                                        ->get();
                                    $product_images_hover = DB::table(
                                        'product_images'
                                    )
                                        ->select('product_image_name')
                                        ->where(
                                            'product_id',
                                            $produk_serupa->product_id
                                        )
                                        ->orderBy('product_image_id', 'desc')
                                        ->limit(1)
                                        ->get();
                                    ?>
                                    @foreach($product_images as $product_image)
                                        <img class="img-serupa" src="../asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$produk_serupa->product_name}}" class="product-image">
                                    @endforeach
                                    
                                </a>
                              
                            </figure>

                            <div class="product-body">
                                <div class="product-cat">
                                    <a href="../produk_supplier/kategori[{{$produk_serupa->category_id}}]">{{$produk_serupa->nama_kategori}}</a>
                                </div>

                                <div class="mb-1"></div>

                                <div class="product-cat">
                                    <a href="../produk_supplier/toko[{{$produk_serupa->merchant_id}}]"><b>{{$produk_serupa->nama_merchant}}</b></a>
                                </div><!-- End .product-cat -->
                                
                                <div class="mb-1"></div>

                                <h3 class="product-title"><a href="../lihat_produk_supplier/{{$produk_serupa->product_id}}">{{$produk_serupa->product_name}}</a></h3>

                                <div class="mb-1"></div>

                                <div class="product-price">
                                    <?php
                                    $harga_produk =
                                        "Rp " .
                                        number_format(
                                            $produk_serupa->price,
                                            0,
                                            ',',
                                            '.'
                                        );
                                    echo $harga_produk;
                                    ?>
                                </div>
                                
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
                            <form action="../PostTinjauan/{{$product->product_id}}" method="post">
                            @csrf
                                <div class="rating">
                                    <input type="radio" name="nilai_review" id="star1-modal" value="5"><label for="star1"></label>
                                    <input type="radio" name="nilai_review" id="star2-modal" value="4"><label for="star2"></label>
                                    <input type="radio" name="nilai_review" id="star3-modal" value="3"><label for="star3"></label>
                                    <input type="radio" name="nilai_review" id="star4-modal" value="2"><label for="star4"></label>
                                    <input type="radio" name="nilai_review" id="star5-modal" value="1"><label for="star5"></label>
                                </div><br>
                                
                                <div class="form-group">
                                    <label for="isi_review">Isi Ulasan *</label>
                                    <input type="text" class="form-control" id="isi_review" name="isi_review" placeholder="Berikan ulasan anda terkait produk" required>
                                </div><!-- End .form-group -->

                                <div class="form-footer">
                                    <button type="submit" class="btn btn-outline-primary-2 btn-round">
                                        <span>Kirim</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
    var MainImg = document.getElementById('MainImg');
    var smalling = document.getElementsByClassName('small-img');

    smalling[0].onclick = function() {
        MainImg.src = smalling[0].src;
    }
    smalling[1].onclick = function() {
        MainImg.src = smalling[1].src;
    }
    smalling[2].onclick = function() {
        MainImg.src = smalling[2].src;
    }
    smalling[3].onclick = function() {
        MainImg.src = smalling[3].src;
    }
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    <?php if ($cek_merchant_address > 0) { ?>
    $merchant_address_id = <?php echo $merchant_address->merchant_address_id; ?>
    <?php } ?>

    <?php if (!$cek_wishlist) { ?>
    $("#label_hapus_produk_keinginan").hide();
    <?php } elseif ($cek_wishlist) { ?>
    $("#label_tambah_produk_keinginan").hide();
    <?php } ?>
    
</script>

<script src="{{ asset('asset/js/lihat_produk.js') }}"></script>

<script src="{{ URL::asset('asset/js/function_2.js') }}"></script>


@endsection
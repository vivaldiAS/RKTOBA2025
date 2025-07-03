@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Toko')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <p>Tambahkan produk anda</p>
    <a class="nav-link btn btn-outline-primary-2" href="./tambah_jasa_kreatif">
        <span>TAMBAH JASA</span>
        <i class="icon-long-arrow-right"></i>
    </a>

    <div class="mb-4"></div>

    <div class="tab-content">
        <div class="tab-pane p-0 fade show active" id="top-all-tab" role="tabpanel" aria-labelledby="top-all-link">
            <div class="products">
                <div class="row justify-content-center">

                    @foreach($services as $service)
                    <div class="col-6 col-md-4 col-lg-4 col-xl-3">
                        <div class="product product-11 text-center">
                            <figure class="product-media">
                                <a href="./edit_jasa_kreatif/{{$service->service_id}}">
                                    <?php
                                        $service_images = DB::table('service_images')->select('service_image_name')->where('service_id', $service->service_id)->orderBy('service_image_id', 'asc')->limit(1)->get();
                                        $service_images_hover = DB::table('service_images')->select('service_image_name')->where('service_id', $service->service_id)->orderBy('service_image_id', 'desc')->limit(1)->get();
                                    ?>
                                    @foreach($service_images as $service_image)
                                        <img src="./asset/u_file/service_image/{{$service_image->service_image_name}}" alt="Service image" class="product-image">
                                    @endforeach
                                    
                                    @foreach($service_images_hover as $service_image_hover)
                                        <img src="./asset/u_file/service_image/{{$service_image_hover->service_image_name}}" alt="Service image" class="product-image-hover">
                                    @endforeach
                                </a>
                            </figure><!-- End .product-media -->

                            <div class="">
                                <div class="mb-1"></div>

                                <div class="product-cat">
                                    <a href="#">{{$service->nama_sub_kategori}}</a>
                                </div><!-- End .product-cat -->
                                
                                <div class="mb-1"></div>
                                
                                <!-- <hr style="margin:0px; border-top:1px solid grant; "> -->
                                
                                <div class="mb-1"></div>

                                <h3 class="product-title"><a href="./edit_produk/{{$service->service_id}}">{{$service->service_name}}</a></h3><!-- End .product-title -->
                                
                                <div class="mb-1"></div>

                                <div class="product-price">
                                    <?php
                                        $harga_produk = "Rp " . number_format($service->price,0,',','.');     
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


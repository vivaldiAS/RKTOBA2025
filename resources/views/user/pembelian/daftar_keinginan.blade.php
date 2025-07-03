@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <div class="page-content">
        <div class="container-product">
            @if($cek_wishlists)
            <table class="table table-wishlist table-mobile col-lg-12">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Toko Asal</th>
                        <th>Status Stok</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($wishlists as $wishlist)
                    <tr>
                        <td class="product-col">
                            <div class="product">
                                <input type="number" class="form-control" name="product_id[]" value="{{$wishlist->product_id}}" hidden required>
                                <figure class="product-media">
                                    @if ($wishlist->type == 'supplier')
                                        <a href="./lihat_produk_supplier/{{$wishlist->product_id}}">
                                    @else
                                        <a href="./lihat_produk/{{$wishlist->product_id}}">
                                    @endif
                                    <?php
                                        $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $wishlist->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                    ?>
                                    @foreach($product_images as $product_image)
                                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$wishlist->product_name}}">
                                    @endforeach
                                    </a>
                                </figure>

                                <h3 class="product-title">
                                    @if ($wishlist->type == 'supplier')
                                        <a href="./lihat_produk_supplier/{{$wishlist->product_id}}">{{$wishlist->product_name}}</a>
                                    @else
                                        <a href="./lihat_produk/{{$wishlist->product_id}}">{{$wishlist->product_name}}</a>
                                    @endif
                                </h3><!-- End .product-title -->
                            </div><!-- End .product -->
                        </td>
                        <td class="price-col">
                            <?php
                                $harga_produk = "Rp." . number_format($wishlist->price,0,',','.');     
                                echo $harga_produk
                            ?>
                        </td>
                        <td class="stock-col">
                            @if ($wishlist->type == 'supplier')
                                <a href="./produk_supplier/toko[{{$wishlist->merchant_id}}]">{{$wishlist->nama_merchant}}</a>
                            @else
                                <a href="./produk/toko[{{$wishlist->merchant_id}}]">{{$wishlist->nama_merchant}}</a>
                            @endif
                        </td>
                        <td class="stock-col">
                            <?php
                                $stok = DB::table('stocks')->select('stok')->where('product_id', $wishlist->product_id)->first();     
                            ?>
                            @if($stok->stok > 0)
                            <span class="in-stock">Tersedia</span>
                            @elseif($stok->stok == 0)
                            <span class="out-of-stock">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td class="remove-col"><a href="./hapus_daftar_keinginan/{{$wishlist->wishlist_id}}" class="btn-remove"><i class="icon-close"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table><!-- End .table table-wishlist -->
            @endif
        </div><!-- End .container -->
    </div><!-- End .page-content -->
</div><!-- .End .tab-pane -->
@if(!$cek_wishlists)
<div class="col-md-12" align="center">
    <h6 style="color:darkred"><b>TIdak ada Produk Dalam Daftar Keinginan. <a href="./produk">Ayo Lihat Produk .</a></b></h6>
</div>
@endif


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


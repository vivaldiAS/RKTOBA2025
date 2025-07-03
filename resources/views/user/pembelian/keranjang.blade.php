@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

<style>
    .store-name{
        margin: 0;
        padding: 0;
    }
</style>

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <div class="row">
                @foreach($merchants as $merchants)
                    @foreach($cart_by_merchants as $carts_by_merchant)
                        @if($carts_by_merchant->merchant_id == $merchants->merchant_id)
                            <form action="./checkout/{{$merchants->merchant_id}}" method="post" enctype="multipart/form-data" class="col-lg-12">
                                @csrf
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr align="center">
                                            <th colspan="5">
                                                 <h4>{{$merchants->nama_merchant}}</h4>
                                            </th>
                                        </tr>
                                        <tr align="center">
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($carts as $cart)
                                        @if($cart->merchant_id == $merchants->merchant_id)
                                            @foreach($stocks as $stock)
                                                @if($stock->product_id == $cart->product_id)
                                                    @if($stock->stok > 0)
                                                    
                                                    <tr align="center">
                                                        <td class="product-col">
                                                           
                                                            <div class="product">
                                                                <input type="number" class="form-control" name="product_id[]" value="{{$cart->product_id}}" hidden required>
                                                                <figure class="product-media">
                                                                    @if ($cart->type == 'supplier')
                                                                        <a href="./lihat_produk_supplier/{{$cart->product_id}}">
                                                                    @else
                                                                        <a href="./lihat_produk/{{$cart->product_id}}">
                                                                    @endif
                                                                    <?php
                                                                        $product_images = DB::table('product_images')->select('product_image_name')->where('product_id', $cart->product_id)->orderBy('product_image_id', 'asc')->limit(1)->get();
                                                                    ?>
                                                                    @foreach($product_images as $product_image)
                                                                        <img src="./asset/u_file/product_image/{{$product_image->product_image_name}}" alt="{{$cart->product_name}}">
                                                                    @endforeach
                                                                    </a>
                                                                </figure>

                                                                <h3 class="product-title">
                                                                    @if ($cart->type == 'supplier')
                                                                        <a href="./lihat_produk_supplier/{{$cart->product_id}}">{{$cart->product_name}}</a>
                                                                    @else
                                                                        <a href="./lihat_produk/{{$cart->product_id}}">{{$cart->product_name}}</a>
                                                                    @endif
                                                                </h3><!-- End .product-title -->
                                                            </div><!-- End .product -->
                                                        </td>
                                                        <td class="price-col" id="harga">
                                                            <?php
                                                                $harga_produk = "Rp." . number_format($cart->price,0,',','.');     
                                                                echo $harga_produk
                                                            ?>/item
                                                        </td>
                                                        <td class="quantity-col">
                                                            <div class="cart-product-quantity">
                                                                <input type="number" class="form-control" name="jumlah_masuk_keranjang[]" id="jumlah_masuk_keranjang[{{$cart->cart_id}}]"
                                                                    value="{{$cart->jumlah_masuk_keranjang}}" min="1" max="{{$stock->stok}}"
                                                                    step="1" data-decimals="0" onchange="total{{$cart->cart_id}}()" required>

                                                            </div><!-- End .cart-product-quantity -->
                                                        </td>
                                                        <script>
                                                            function total{{$cart->cart_id}}()
                                                            {
                                                                let jumlah_barang<?php echo $cart->cart_id ?> = document.getElementById("jumlah_masuk_keranjang[{{$cart->cart_id}}]").value;
                                                                let total_harga_table<?php echo $cart->cart_id ?> = document.getElementById("total_harga_table[{{$cart->cart_id}}]");
                                                                
                                                                const rupiah = (number)=>{
                                                                    return new Intl.NumberFormat("id-ID", {
                                                                    style: "currency",
                                                                    currency: "IDR"
                                                                    }).format(number);
                                                                }
                                                                total_harga_table<?php echo $cart->cart_id?>.innerHTML = rupiah(jumlah_barang<?php echo $cart->cart_id ?> * <?php echo $cart->price ?>) 
                                                            }
                                                        </script>
                                                        <td class="total-col" id="total_harga_table[{{$cart->cart_id}}]">
                                                            <?php
                                                                $total = $cart->price * $cart->jumlah_masuk_keranjang;
                                                                $total_harga_produk = "Rp." . number_format($total,0,',','.');  
                                                                echo $total_harga_produk;
                                                            ?>
                                                        </td>
                                                        <td class="remove-col"><a href="./hapus_keranjang/{{$cart->cart_id}}" class="btn-remove"><i class="icon-close"></i></a></td>
                                                    </tr>
                                                    @elseif($stock->stok == 0)
                                                        <input type="number" class="form-control" name="product_id[]" value="{{$cart->product_id}}" hidden required>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                                @if($cek_carts)
                                <div class="cart-bottom">
                                @if($merchants->on_vacation != 1)
                                    <button type="submit" class="btn btn-outline-primary-2"><span>CHECKOUT</span><i class="icon-long-arrow-right"></i></button>
                                @endif
                                </div><!-- End .cart-bottom -->
                                @endif
                            </form>

                            <!-- <aside class="col-lg-5">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3>

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>$160.00</td>
                                            </tr>
                                            <tr class="summary-shipping">
                                                <td>Shipping:</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                                    </div>
                                                </td>
                                                <td>$0.00</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="standart-shipping">Standart:</label>
                                                    </div>
                                                </td>
                                                <td>$10.00</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="express-shipping">Express:</label>
                                                    </div>
                                                </td>
                                                <td>$20.00</td>
                                            </tr>

                                            <tr class="summary-shipping-estimate">
                                                <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>$160.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                                </div>

                                <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                            </aside> -->

                        @endif
                    @endforeach

                    <!-- Jasa_Kreatif -->
                    @foreach($service_cart_by_merchants as $service_cart_by_merchant)
                        @if($service_cart_by_merchant->merchant_id == $merchants->merchant_id)
                            <form action="./checkout_jasa/{{$merchants->merchant_id}}" method="post" enctype="multipart/form-data" class="col-lg-9">
                                @csrf
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr align="center">
                                            <th colspan="5">
                                                <h4>{{$merchants->nama_merchant}}</h4>
                                            </th>
                                        </tr>
                                        <tr align="center">
                                            <th>Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($service_carts as $service_cart)
                                        @if($service_cart->merchant_id == $merchants->merchant_id)
                                            <tr align="center">
                                                <td class="product-col">
                                                    <div class="product">
                                                        <input type="number" class="form-control" name="service_id[]" value="{{$service_cart->service_id}}" hidden required>
                                                        <figure class="product-media">
                                                            <a href="./lihat_jasa_kreatif/{{$service_cart->service_id}}">
                                                            <?php
                                                                $service_images = DB::table('service_images')->select('service_image_name')->where('service_id', $service_cart->service_id)->orderBy('service_image_id', 'asc')->limit(1)->get();
                                                            ?>
                                                            @foreach($service_images as $service_image)
                                                                <img src="./asset/u_file/service_image/{{$service_image->service_image_name}}" alt="{{$service_cart->service_name}}">
                                                            @endforeach
                                                            </a>
                                                        </figure>

                                                        <h3 class="product-title">
                                                            <a href="./lihat_jasa_kreatif/{{$service_cart->service_id}}">{{$service_cart->service_name}}</a>
                                                        </h3><!-- End .product-title -->
                                                    </div><!-- End .product -->
                                                </td>
                                                <td class="price-col" id="harga">
                                                    <?php
                                                        $harga_produk = "Rp." . number_format($service_cart->price,0,',','.');     
                                                        echo $harga_produk
                                                    ?>
                                                </td>
                                                <td class="quantity-col">
                                                    <div class="cart-product-quantity">
                                                        <input type="number" class="form-control" name="jumlah_masuk_keranjang[]" id="jumlah_masuk_keranjang[{{$service_cart->cart_id}}]"
                                                            value="{{$service_cart->jumlah_masuk_keranjang}}" min="1"
                                                            step="1" data-decimals="0" onchange="total{{$service_cart->cart_id}}()" required>

                                                    </div><!-- End .cart-product-quantity -->
                                                </td>
                                                <script>
                                                    function total{{$service_cart->cart_id}}()
                                                    {
                                                        let jumlah_barang<?php echo $service_cart->cart_id ?> = document.getElementById("jumlah_masuk_keranjang[{{$service_cart->cart_id}}]").value;
                                                        let total_harga_table<?php echo $service_cart->cart_id ?> = document.getElementById("total_harga_table[{{$service_cart->cart_id}}]");
                                                        
                                                        const rupiah = (number)=>{
                                                            return new Intl.NumberFormat("id-ID", {
                                                            style: "currency",
                                                            currency: "IDR"
                                                            }).format(number);
                                                        }
                                                        total_harga_table<?php echo $service_cart->cart_id?>.innerHTML = rupiah(jumlah_barang<?php echo $service_cart->cart_id ?> * <?php echo $service_cart->price ?>) 
                                                    }
                                                </script>
                                                <td class="total-col" id="total_harga_table[{{$service_cart->cart_id}}]">
                                                    <?php
                                                        $total = $service_cart->price * $service_cart->jumlah_masuk_keranjang;
                                                        $total_harga_produk = "Rp." . number_format($total,0,',','.');  
                                                        echo $total_harga_produk;
                                                    ?>
                                                </td>
                                                <td class="remove-col"><a href="./hapus_keranjang/{{$service_cart->cart_id}}" class="btn-remove"><i class="icon-close"></i></a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                                @if($cek_service_carts)
                                <div class="cart-bottom">
                                    <button type="submit" class="btn btn-outline-primary-2"><span>CHECKOUT</span><i class="icon-long-arrow-right"></i></button>
                                </div><!-- End .cart-bottom -->
                                @endif
                            </form>

                            <!-- <aside class="col-lg-5">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3>

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-subtotal">
                                                <td>Subtotal:</td>
                                                <td>$160.00</td>
                                            </tr>
                                            <tr class="summary-shipping">
                                                <td>Shipping:</td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="free-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="free-shipping">Free Shipping</label>
                                                    </div>
                                                </td>
                                                <td>$0.00</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="standart-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="standart-shipping">Standart:</label>
                                                    </div>
                                                </td>
                                                <td>$10.00</td>
                                            </tr>

                                            <tr class="summary-shipping-row">
                                                <td>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="express-shipping" name="shipping" class="custom-control-input">
                                                        <label class="custom-control-label" for="express-shipping">Express:</label>
                                                    </div>
                                                </td>
                                                <td>$20.00</td>
                                            </tr>

                                            <tr class="summary-shipping-estimate">
                                                <td>Estimate for Your Country<br> <a href="dashboard.html">Change address</a></td>
                                                <td>&nbsp;</td>
                                            </tr>

                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>$160.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <a href="checkout.html" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                                </div>

                                <a href="category.html" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE SHOPPING</span><i class="icon-refresh"></i></a>
                            </aside> -->

                        @endif
                    @endforeach
                @endforeach
                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</div><!-- .End .tab-pane -->
@if(!$cek_carts && !$cek_service_carts)
<div class="col-md-12" align="center">
    <h6 style="color:darkred"><b>Keranjang Kosong. <a href="./produk">Ayo Belanja.</a></b></h6>
</div>
@endif


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection
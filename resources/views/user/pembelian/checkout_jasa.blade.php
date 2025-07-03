@extends('user/pembelian/layout/main_checkout')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('container')

<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
    <div class="page-content">
        <div class="cart">
            <div class="container">
                <form action="/PostBeliJasa" method="post" enctype="multipart/form-data" class="row">
                    <input type="text" name="merchant_id" value="{{$merchant_id}}" readonly hidden>
                    <div class="col-lg-9">
                        @csrf
                        <table class="table table-cart table-mobile">
                            <thead>
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
                                <?php
                                    $harga_produk = "Rp." . number_format($service_cart->price,0,',','.');
                                    $subtotal = $service_cart->price * $service_cart->jumlah_masuk_keranjang;
                                    $subtotal_harga_produk = "Rp." . number_format($subtotal,0,',','.');  
                                ?>
                                <tr align="center">
                                    <td class="product-col">
                                        <div class="product">
                                            <input type="number" class="form-control" name="service_id[]" value="{{$service_cart->service_id}}" hidden required>
                                            <figure class="product-media">
                                                <a href="../lihat_jasa_kreatif/{{$service_cart->service_id}}">
                                                    <?php
                                                        $service_images = DB::table('service_images')->select('service_image_name')->where('service_id', $service_cart->service_id)->orderBy('service_image_id', 'asc')->limit(1)->get();
                                                    ?>
                                                    @foreach($service_images as $service_image)
                                                        <img src="../asset/u_file/service_image/{{$service_image->service_image_name}}" alt="{{$service_cart->service_name}}">
                                                    @endforeach
                                                </a>
                                            </figure>

                                            <h3 class="product-title">
                                                <a href="../lihat_jasa_kreatif/{{$service_cart->service_id}}">{{$service_cart->service_name}}</a>
                                            </h3><!-- End .product-title -->
                                        </div><!-- End .product -->
                                    </td>
                                    <td>
                                        {{$harga_produk}}
                                    </td>
                                    <td class="quantity-col">
                                        <div class="cart-product-quantity">
                                            {{$service_cart->jumlah_masuk_keranjang}}
                                        </div><!-- End .cart-product-quantity -->
                                    </td>
                                    <td>
                                        {{$subtotal_harga_produk}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table><!-- End .table table-wishlist -->
                        <div class="cart-bottom">
                            <div class="input-group-append">
                                <a href="../keranjang" class="btn btn-outline-primary-2" type="submit">KEMBALI</a>
                            </div><!-- .End .input-group-append -->
                        </div><!-- End .cart-bottom -->
                    </div>

                    @if($cek_cart_jasa > 0)
                    <aside class="col-lg-3">
                        <div class="summary">
                            <h3 class="summary-title">Form Pemesanan</h3>
                            <table class="table table-summary">
                                <tbody>
                                    <tr>
                                        <td><label>Alamat* :</label></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr class="">
                                        <td>
                                            <input class="form form-control" type="text" name="address" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label>Nomor Telepon* :</label></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr class="">
                                        <td>
                                            <input class="form form-control" type="text" name="phone_number" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label>Tanggal Mulai* :</label></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr class="">
                                        <td>
                                            <input class="form form-control" type="date" name="start_date" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label>Tanggal Selesai* :</label></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr class="">
                                        <td>
                                            <input class="form form-control" type="date" name="end_date" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><label>Catatan* :</label></td>
                                        <td></td>
                                    </tr>
                                    
                                    <tr class="">
                                        <td>
                                            <textarea name="note" id="note" cols="30" rows="10" required></textarea>
                                        </td>
                                    </tr>

                                    <tr class="">
                                        <td>
                                            <button class="btn btn-primary" type="submit" name="submit">PESAN</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div id="checkout"></div>
                        </div>

                        <!-- <div id="ongkir">
                        </div> -->

                        
                    </aside>
                    @elseif($cek_cart_jasa == 0)
                    
                    @endif
                </form><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .cart -->
    </div><!-- End .page-content -->
</div><!-- .End .tab-pane -->

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $merchant_id = <?php echo $merchant_id ?>;
    
    // $province_id = (disini ada tag) echo $merchant_address->province_id ?>;
    // $city_id = (disini ada tag php) echo $merchant_address->city_id ?>;
    // $subdistrict_id = (disini ada tag php) echo $merchant_address->subdistrict_id ?>;
    $total_harga_checkout = <?php echo $total_harga_jasa->total_harga ?>;
    // $total_harga_checkout_mentah = 0;
    // $ongkir = 0;
    // $potongan_pembelian = 0;
    // $potongan_ongkir = 0;
    
    // $("#voucher_ongkir_table").hide();

    // $("#alamat_table").hide();

    // $("#province_address_row").hide();
    // $("#city_address_row").hide();
    // $("#subdistrict_address_row").hide();

    // $("#pengiriman_table").hide();
    // $("#pengiriman_lokal_tr").hide();
    // $("#service_row").hide();
    
</script>
<script src="{{ URL::asset('asset/js/function.js') }}"></script>

@endsection


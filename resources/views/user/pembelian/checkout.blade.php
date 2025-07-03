@extends('user/pembelian/layout/main_checkout')

@section('title', 'Rumah Kreatif Toba - Checkout')


@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
@endsection

<meta name="csrf-token" content="{{ csrf_token() }}"/>

<style>
    .catatan {
        height: 42px;
        padding: .85rem 2rem;
        font-size: 1.4rem;
        line-height: 1.5;
        font-weight: 300;
        color: #777;
        background-color: #fafafa;
        border: 1px solid #ebebeb;
        border-radius: 0;
        margin-bottom: 2rem;
        transition: all 0.3s;
        box-shadow: none;
        display: block;
        width: 100%;
    }
</style>

@section('container')

    <div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
        <div class="page-content">
            <div class="cart">
                <div class="container">
                    <form action="../PostBeliProduk" method="post" enctype="multipart/form-data" class="row">
                        <input type="text" name="merchant_id" value="{{$merchant_id}}" readonly hidden>
                        <div class="col-lg-9">

                            <div class="cart-item-wrapper">
                                <h6 class="content-caption">Produk</h6>
                                <div class="card-contents">
                                    <div class="cart-per-item">
                                        @csrf
                                        @foreach($carts as $cart)
                                                <?php
                                                $harga_produk =
                                                    "Rp." .
                                                    number_format($cart->price, 0, ',', '.');
                                                $subtotal =
                                                    $cart->price *
                                                    $cart->jumlah_masuk_keranjang;
                                                $subtotal_harga_produk =
                                                    "Rp." .
                                                    number_format($subtotal, 0, ',', '.');
                                                ?>
                                            <div class="card-itemss">
                                                <div class="img-items-cart">
                                                    <a href="../lihat_produk/{{$cart->product_id}}">
                                                            <?php $product_images = DB::table(
                                                            'product_images'
                                                        )
                                                            ->select('product_image_name')
                                                            ->where(
                                                                'product_id',
                                                                $cart->product_id
                                                            )
                                                            ->orderBy(
                                                                'product_image_id',
                                                                'asc'
                                                            )
                                                            ->limit(1)
                                                            ->get(); ?>
                                                        @foreach($product_images as $product_image)
                                                            <img
                                                                src="../asset/u_file/product_image/{{$product_image->product_image_name}}"
                                                                class="img-carts" alt="{{$cart->product_name}}">
                                                        @endforeach
                                                    </a>
                                                </div>
                                                <div class="items-info">
                                                    <div>
                                                        <h3 class="product-title">
                                                            <a href="../lihat_produk/{{$cart->product_id}}">{{$cart->product_name}}</a>
                                                        </h3>
                                                    </div>
                                                    <div class="product-price"
                                                    ">
                                                    {{$harga_produk}}
                                                </div>
                                                <div class="cart-product-quantity">
                                                    Jumlah :{{$cart->jumlah_masuk_keranjang}}
                                                </div>

                                            </div>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="metode-wrapper">
                                    <p> Pilih Metode</p>
                                    <div class="select-metode">
                                        <select class="method-menu" name="metode_pembelian" id="metode_pembelian">
                                            <option selected disabled>Metode Pembelian</option>
                                            <option value="ambil_ditempat" required>Ambil Ditempat</option>
                                            <option value="pesanan_dikirim" required>Pesanan Dikirim</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-contents">
                                <table class="table table-summary" id="">
                                    <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <label>Catatan</label><br>
                                            <textarea class="catatan" name="catatan"
                                                      placeholder="Berikan catatan terkait pembelian anda."></textarea>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="alamat-wrapper">
                            <table class="table table-summary" id="alamat_table">
                                <tbody>
                                <tr class="summary-shipping-estimate">
                                    <td colspan="2">Alamat Anda:</td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Jalan</label>
                                        <select name="alamat_purchase" id="street_address"
                                                class="custom-select form-control">
                                            <option value="" id="disabled_alamat" disabled selected>Pilih Alamat
                                                Pengiriman
                                            </option>
                                            @foreach($user_address as $user_address)
                                                <option
                                                    value="{{$user_address->user_address_id}}">{{$user_address->user_street_address}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <label>Provinsi</label>
                                        <select name="province" id="province_address"
                                                class="custom-select form-control">
                                            <option value="" disabled selected>Pilih Provinsi</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label>Kabupaten/Kota</label>
                                        <select name="city" id="city_address" class="custom-select form-control">
                                            <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                                        </select>
                                    </td>
                                    <td>
                                        <label>Kecamatan</label>
                                        <select name="subdistrict" id="subdistrict_address"
                                                class="custom-select form-control">
                                            <option value="" disabled selected>Pilih Kecamatan</option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="voucher-col">
                            <table class="table table-summary">
                                <tbody>
                                <tr class="content-caption">
                                    <td colspan="2">Gunakan Voucher Pembelian:</td>
                                </tr>
                                <?php
                                $jumlah_pembelian_vouchers = DB::table(
                                    'vouchers'
                                )
                                    ->where('is_deleted', 0)
                                    ->where(
                                        'tanggal_berlaku',
                                        '<=',
                                        date('Y-m-d')
                                    )
                                    ->where(
                                        'tanggal_batas_berlaku',
                                        '>=',
                                        date('Y-m-d')
                                    )
                                    ->where('tipe_voucher', "pembelian")
                                    ->count(); ?>
                                @if($jumlah_vouchers > 0)
                                        <?php
                                        $cek_pembelian_vouchers = 0;
                                        foreach (
                                            $get_pembelian_vouchers
                                            as $cek_get_pembelian_voucher
                                        ) {
                                            $cek_target_kategori = explode(
                                                ",",
                                                $cek_get_pembelian_voucher->target_kategori
                                            );
                                            foreach (
                                                $cek_target_kategori
                                                as $cek_target_kategori_get
                                            ) {
                                                foreach (
                                                    $carts
                                                    as $cek_cart_voucher
                                                ) {
                                                    if (
                                                        $cek_target_kategori_get ==
                                                        $cek_cart_voucher->category_id
                                                    ) {
                                                        $cek_pembelian_vouchers = 1;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    @if($jumlah_pembelian_vouchers > 0 && $cek_pembelian_vouchers != 0)
                                        @if($metode_pembelian == null)
                                            <tr id="voucher_pembelian_tr">
                                                <td colspan="2" id="voucher_pembelian_td">
                                                    <input class="form-control" id="disabled_vmethod"
                                                           value="Pilih metode pembelian terlebih dahulu." disabled>
                                                    <select name="voucher_pembelian" id="voucher_pembelian"
                                                            class="custom-select form-control">

                                                    </select>
                                                </td>
                                            </tr>
                                        @elseif($metode_pembelian != null)

                                        @endif
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                <input class="form-control" value="Tidak ada voucher pembelian."
                                                       disabled>
                                            </td>
                                        </tr>
                                    @endif

                                @else
                                    <tr>
                                        <td colspan="2">
                                            <input class="form-control" value="Tidak ada voucher yang bisa diambil."
                                                   disabled>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="pengiriman-wrapper">
                            <table class="table table-summary" id="pengiriman_table">
                                <tbody>
                                <tr class="summary-shipping-estimate">
                                    <td>Pengiriman</td>
                                </tr>
                                <tr class="summary-shipping-estimate" id="courier_tr">
                                    <td>
                                        <label>Kurir *</label>
                                        <select name="courier" id="courier" class="custom-select form-control">
                                            <option value="" disabled selected>Pilih Kurir</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="summary-shipping-estimate" id="pengiriman_lokal_tr">
                                    <td id="pengiriman_lokal_td">
                                        <label>Pengiriman Lokal *</label>
                                        <select name="courier" id="pengiriman_lokal" class="custom-select form-control">
                                            <option value="" disabled selected>Pilih Pengiriman</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="summary-shipping-estimate" id="service_row">
                                    <td colspan="2">
                                        <label>Servis *</label>
                                        <select name="service" id="service" class="custom-select form-control">
                                            <option value="" id="disabled_service" disabled selected>Pilih Servis
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="voucher-ongkir">
                            <table class="table table-summary" id="voucher_ongkir_table">
                                <tbody>
                                <tr class="summary-shipping-estimate">
                                    <td colspan="2">Gunakan Voucher Ongkos Kirim:</td>
                                </tr>
                                @if($jumlah_vouchers > 0)
                                    @if($cek_ongkos_kirim_vouchers > 0)
                                        <tr id="voucher_ongkos_kirim_tr">
                                            <td colspan="2" id="voucher_ongkos_kirim_td">
                                                <select name="voucher_ongkos_kirim" id="voucher_ongkos_kirim"
                                                        class="custom-select form-control">
                                                    <option value="" id="disabled_voucher_ongkir" disabled selected>
                                                        Pilih Voucher Ongkos Kirim
                                                    </option>
                                                    @foreach($get_ongkos_kirim_vouchers as $ongkos_kirim_voucher)
                                                            <?php $rp_potongan_ongkir =
                                                            "Rp " .
                                                            number_format(
                                                                $ongkos_kirim_voucher->potongan,
                                                                0,
                                                                ',',
                                                                '.'
                                                            ); ?>
                                                        <option
                                                            value="{{$ongkos_kirim_voucher->voucher_id}}">{{$ongkos_kirim_voucher->nama_voucher}}
                                                            ({{$rp_potongan_ongkir}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="2">
                                                <input class="form-control" value="Tidak ada voucher ongkos kirim."
                                                       disabled>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <td colspan="2">
                                            <input class="form-control" value="Tidak ada voucher yang bisa diambil."
                                                   disabled>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="map hidden" id="map">
                        </div>
                        <div class="cart-bottom mt-3">
                            <div class="input-group-append">
                                <a href="../keranjang" class="btn btn-outline-primary-2" type="submit">Sebelumnya</a>
                            </div>
                        </div>
                        </div>

                        @if($cek_cart > 0)
                            <aside class="col-lg-3">
                                <div class="summary">
                                    <h3 class="summary-title">Cart Total</h3>

                                    <table class="table table-summary">
                                        <tbody>
                                        <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>

                                        @foreach($carts as $carts1)
                                                <?php
                                                $subtotal =
                                                    $carts1->price *
                                                    $carts1->jumlah_masuk_keranjang;
                                                $subtotal_harga_produk =
                                                    "Rp." .
                                                    number_format($subtotal, 0, ',', '.');
                                                ?>
                                            <tr>
                                                <td>
                                                    <a href="../lihat_produk/{{$carts1->product_id}}">{{$carts1->product_name}}</a>
                                                </td>
                                                <td>
                                                    <p id="subtotal_harga_produk_{{$carts1->product_id}}">
                                                        <a>{{$subtotal_harga_produk}}</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <input name="harga_pembelian" value="{{$total_harga->total_harga}}" hidden>

                                    <table class="table table-summary">
                                            <?php $rp_total_harga_checkout =
                                            "Rp." .
                                            number_format(
                                                $total_harga->total_harga,
                                                0,
                                                ',',
                                                '.'
                                            ); ?>
                                        <tbody>
                                        <tr class="summary-subtotal" id="invoice_subtotal">
                                            <td>Subtotal:</td>
                                            <td>
                                                {{$rp_total_harga_checkout}}
                                            </td>
                                        </tr>

                                        <tr class="summary-subtotal" id="invoice_ongkir">
                                        </tr>

                                        <tr class="summary-subtotal" id="jumlah_potongan_subtotal">
                                            <input name="potongan_pembelian" value="0" hidden>
                                        </tr>

                                        <tr class="summary-subtotal" id="total_potongan_ongkir">
                                        </tr>

                                        <tr class="summary-total">
                                            <td>Total:</td>
                                            <td id="total_harga_checkout">
                                                <input name="potongan_pembelian" value="0" hidden>
                                                {{$rp_total_harga_checkout}}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div id="checkout"></div>
                                </div>

                                <!-- <div id="ongkir">
                                </div> -->


                            </aside>
                        @elseif($cek_cart == 0)

                        @endif
                    </form><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .cart -->
        </div><!-- End .page-content -->
    </div><!-- .End .tab-pane -->

    <script src="https://code.jquery.com/jquery-3.6.1.js"
            integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $merchant_id = <?php echo $merchant_id; ?>;

        $total_berat = <?php echo $total_berat->total_berat; ?>;
        $province_id = <?php echo $merchant_address->province_id; ?>;
        $city_id = <?php echo $merchant_address->city_id; ?>;
        $subdistrict_id = <?php echo $merchant_address->subdistrict_id; ?>;
        $total_harga_checkout = <?php echo $total_harga->total_harga; ?>;
        $total_harga_checkout_mentah = 0;
        $ongkir = 0;
        $potongan_pembelian = 0;
        $potongan_ongkir = 0;

        $("#voucher_ongkir_table").hide();

        $("#alamat_table").hide();

        $("#province_address_row").hide();
        $("#city_address_row").hide();
        $("#subdistrict_address_row").hide();

        $("#pengiriman_table").hide();
        $("#pengiriman_lokal_tr").hide();
        $("#service_row").hide();
        $("#voucher_pembelian").hide();

    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_API_KEY")  }}&callback=initMap"
        async defer></script>
    <script src="{{ URL::asset('asset/js/function.js') }}"></script>


    <!-- Usability Testing Maze -->
    <script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


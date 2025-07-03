<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Invoice Pembelian</title>
        <meta name="keywords" content="HTML5 Template">
        <meta name="description" content="Marketplace Rumah Kreatif Toba">
        <meta name="author" content="p-themes">
        <!-- Favicon -->
        <link rel="icon" type="image/png" sizes="32x32" href="../asset/Image/logo_rkt.png">
        <!-- Plugins CSS File -->
        <link rel="stylesheet" href="../asset/Molla/assets/css/bootstrap.min.css">
        <!-- Main CSS File -->
        <link rel="stylesheet" href="../asset/Molla/assets/css/style.css">
    </head>

    <body>
        <center>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                                <p class=""><b>
                                    Invoice
                                </b></p>
                        </div><!-- End .card-dashboard -->
                    </div>
                </div><!-- End .row -->
                
                <div class="mb-1"></div>

                <div class="row">
                    <table class="col-sm-5">
                        <tr valign="top" height="100px">
                            <td colspan="3">
                                <img src="../asset/Image/logo_rkt.png" alt="RKT Logo" width="80">
                            </td>
                        </tr>
                        <tr valign="top" valign="top"><td colspan="3">DITERBITKAN ATAS NAMA</td></tr>
                        <tr valign="top">
                            <td width="100px"><b>Toko</b></td>
                            <td align="center" width="10px"><b>:</b></td>
                            <td> {{$merchant->nama_merchant}}</td>
                        </tr>
                        @if($cek_merchant_address > 0)
                            <tr valign="top">
                                <td width="100px"><b>Alamat Toko</b></td>
                                <td><b>:</b></td>
                                <td>
                                    {{$merchant->nama_merchant}} 
                                    @if($purchases->status_pembelian != "status1" || $purchases->status_pembelian != "status1_ambil")
                                        ({{$merchant->kontak_toko}})
                                    @endif
                                    , {{$merchant_address->merchant_street_address}}, {{$merchant_address->subdistrict_name}}
                                    , {{$merchant_address->city_name}}, {{$merchant_address->province_name}}
                                </td>
                            </tr>
                        @endif
                    </table>

                    <div class="col-sm-1"></div>
                    
                    <table class="col-sm-6">
                        <tr style="font-size:22.5px" height="100px">
                            <td width="195px"><b>Kode Pembelian</b></td>
                            <td align="center" width="10px"><b>:</b></td>
                            <td> {{$purchases->kode_pembelian}}</td>
                        </tr>
                        <tr><td colspan="3" valign="top">UNTUK</td></tr>
                        <tr valign="top">
                            <td width="145px"><b>Pembeli</b></td>
                            <td><b>:</b></td>
                            <td>
                                @if($profile->id == $purchases->user_id)
                                    {{$profile->name}}
                                @endif
                            </td>
                        </tr>
                        <tr valign="top">
                            <td width="145px"><b>Tanggal Pembelian</b></td>
                            <td align="center" width="10px"><b>:</b></td>
                            <td> {{$purchases->created_at}}</td>
                        </tr>
                        @if($purchases->alamat_purchase != null || $purchases->alamat_purchase != "")
                            @if($cek_user_address > 0)
                                <tr valign="top">
                                    <td width="145px"><b>Alamat Pengiriman</b></td>
                                    <td><b>:</b></td>
                                    <td>
                                        @if($profile->id == $purchases->user_id)
                                            {{$profile->name}} ({{$profile->no_hp}})
                                        @endif
                                        , {{$user_address->user_street_address}}, {{$user_address->subdistrict_name}}
                                        , {{$user_address->city_name}}, {{$user_address->province_name}}
                                    </td>
                                </tr>
                            @endif
                        @endif
                    </table>
                </div><!-- End .row -->
                
                <div class="mb-3"></div>

                @foreach($product_purchases as $invoice_product_purchases)
                <a class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
                    <?php
                        $invoice_product_image = DB::table('product_images')->select('product_image_name')->where('product_id', $invoice_product_purchases->product_id)->orderBy('product_image_id', 'asc')->first();
                    ?>

                    <div class="col-md-2"  align="center">
                        <img src="../asset/u_file/product_image/{{$invoice_product_image->product_image_name}}" class="img-fluid" alt="{{$invoice_product_image->product_image_name}}" width="50px" style="padding: 0px">
                    </div>
                    
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{$invoice_product_purchases->product_name}}</p>
                    </div>
                    
                    <?php
                        $jumlah_product_specifications = DB::table('product_specifications')->where('product_id', $invoice_product_purchases->product_id)->count();
                    ?>
                    @if($jumlah_product_specifications == 0)

                    @else
                        @foreach($product_specifications as $product_specification)
                            @if($product_specification->product_id == $invoice_product_purchases->product_id)
                            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                                <p class="text-muted mb-0">{{$product_specification->nama_spesifikasi}}</p>
                            </div>
                            @endif
                        @endforeach
                    @endif

                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">Jumlah: {{$invoice_product_purchases->jumlah_pembelian_produk}}</p>
                    </div>

                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        
                        <?php
                            if($invoice_product_purchases->harga_pembelian_produk == null){
                                $invoice_product_purchases_price = "Rp." . number_format(floor($invoice_product_purchases->price * $invoice_product_purchases->jumlah_pembelian_produk),0,',','.');
                            }
                            
                            else if($invoice_product_purchases->harga_pembelian_produk != null){
                                $invoice_product_purchases_price = "Rp." . number_format(floor($invoice_product_purchases->harga_pembelian_produk),0,',','.');
                            }
                        ?>
                        <p class="text-muted mb-0">{{$invoice_product_purchases_price}}</p>
                    </div>
                    </a>
                @endforeach

                @if($purchases->catatan != null)
                    <div style="padding: 10px;" align="left">
                        <table style="padding: 10px">
                            <tr>
                                <td valign="top">Catatan</td>
                                <td valign="top"> : &nbsp;</td>
                                <td> {{$purchases->catatan}} </td>
                            </tr>
                        </table>
                    </div><br>
                @endif

                <div class="row">
                    <aside class="col-lg-12">
                        <div class="summary">
                            <h3 class="summary-title">Detail Pembayaran</h3><!-- End .summary-title -->

                            <table class="table table-summary">
                                <!-- <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead> -->

                                <tbody>
                                    <tr class="summary-subtotal">
                                        <td>Subtotal:</td>
                                        <td>
                                            <?php
                                                if($purchases->harga_pembelian == null){
                                                    $invoice_total_harga_pembelian = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
                                                    ->where('purchases.checkout_id', $purchases->checkout_id)
                                                    ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
                                                    ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                                                    ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();
                
                                                    $invoice_total_harga_pembelian_fix = "Rp." . number_format($invoice_total_harga_pembelian->total_harga_pembelian,2,',','.');
                                                }
                                                
                                                else if($purchases->harga_pembelian != null){
                                                    $invoice_total_harga_pembelian_fix = "Rp." . number_format(floor($purchases->harga_pembelian),2,',','.');
                                                }
                                            ?>
                                            <a>{{$invoice_total_harga_pembelian_fix}}</a>
                                        </td>
                                    </tr><!-- End .summary-subtotal -->
                                    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status3"
                                    || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status5")
                                    <tr class="summary-subtotal">
                                        <td>Ongkos Kirim [{{$courier_name}}] [{{$service_name}}]:</td>
                                        <td>
                                            <?php
                                                $invoice_ongkir = "Rp." . number_format($ongkir,2,',','.');
                                            ?>
                                            <a>{{$invoice_ongkir}}</a>
                                        </td>
                                    </tr>
                                    @endif
                                    
                                    <?php
                                        $invoice_jumlah_claim_pembelian_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'pembelian')->where('checkout_id', $purchases->checkout_id)
                                        ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->count();

                                        $invoice_jumlah_claim_ongkos_kirim_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'ongkos_kirim')->where('checkout_id', $purchases->checkout_id)
                                        ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->count();
                                    ?>

                                    @if($invoice_jumlah_claim_pembelian_voucher > 0)
                                    <tr class="summary-subtotal">
                                        <td>Voucher Pembelian:</td>
                                        <td><a id="jumlah_potongan_subtotal"></a></td>
                                    </tr>
                                    @endif

                                    @if($invoice_jumlah_claim_ongkos_kirim_voucher > 0)
                                    <tr class="summary-subtotal">
                                        <td>Voucher Ongkos Kirim:</td>
                                        <td><a id="total_potongan_ongkir"></a></td>
                                    </tr>
                                    @endif
                                    
                                    <tr class="summary-total">
                                        <td>Total:</td>
                                        <td>
                                        @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status3"
                                            || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status5")
                                            <a id="invoice_total_harga_produk_kirim"></a>
                                        @else
                                            <a id="invoice_total_harga_produk"></a>
                                        @endif
                                            
                                        </td>
                                    </tr><!-- End .summary-total -->
                                </tbody>
                            </table><!-- End .table table-summary -->
                        </div><!-- End .summary -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->

                <div class="row">
                    @foreach($product_purchases as $product_purchases)
                        <?php
                            $jumlah_claim_pembelian_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'pembelian')->where('checkout_id', $purchases->checkout_id)
                            ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->count();

                            $jumlah_claim_ongkos_kirim_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'ongkos_kirim')->where('checkout_id', $purchases->checkout_id)
                            ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->count();
                            
                            if($product_purchases->harga_pembelian_produk == null){
                                $total_harga_pembelian_perproduk = $product_purchases->price * $product_purchases->jumlah_pembelian_produk;
                            }
                
                            else if($product_purchases->harga_pembelian_produk != null){
                                $total_harga_pembelian_perproduk = $product_purchases->harga_pembelian;
                            }
                            
                            $jumlah_product_purchase = DB::table('product_purchases')->where('purchase_id', $purchases->purchase_id)->count();
                            
                            $cek_target_kategori = 0;
                        ?>
                        
                        @if($jumlah_claim_pembelian_voucher == 0)
                            <?php
                                $total_harga_pembelian_produk = $total_harga_pembelian_perproduk;
                                $total_harga_pembelian_produk_fix = "Rp." . number_format(floor($total_harga_pembelian_produk),0,',','.');
                            ?>
                        @elseif($jumlah_claim_pembelian_voucher > 0)
                            <?php                                                
                                $target_kategori = explode(",", $claim_pembelian_voucher->target_kategori);

                                if($purchases->potongan_pembelian == null){
                                    foreach($target_kategori as $target_kategori){
                                        
                                        $subtotal_harga_produk = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
                                        ->where('purchases.checkout_id', $purchases->checkout_id)->where('category_id', $target_kategori)
                                        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
                                        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                                        ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();
                
                                        // $potongan_subtotal = [];
                                        $potongan_subtotal[] = (int)$subtotal_harga_produk->total_harga_pembelian * $claim_pembelian_voucher->potongan / 100;
                                    }
                
                                    $jumlah_potongan_subtotal = array_sum($potongan_subtotal);
                
                                    if($jumlah_potongan_subtotal <= $claim_pembelian_voucher->maksimal_pemotongan){
                                        $jumlah_potongan_subtotal = array_sum($potongan_subtotal);
                                    }
                            
                                    else if($jumlah_potongan_subtotal > $claim_pembelian_voucher->maksimal_pemotongan){
                                        $jumlah_potongan_subtotal = $claim_pembelian_voucher->maksimal_pemotongan;
                                    }
                
                                    $total_harga_pembelian_keseluruhan = (int)$semua_total_harga_pembelian - $jumlah_potongan_subtotal;
                                }
                
                                else if($purchases->potongan_pembelian != null){
                                    $jumlah_potongan_subtotal = $purchases->potongan_pembelian;
                                    
                                    $total_harga_pembelian_keseluruhan = (int)$purchases->harga_pembelian - $jumlah_potongan_subtotal;
                                }

                            ?>
                        @endif

                        @if($jumlah_claim_pembelian_voucher > 0)
                            <script>
                                const rupiah = (number)=>{
                                    return new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR"
                                    }).format(number);
                                }
                                
                                let jumlah_potongan_subtotal = document.getElementById("jumlah_potongan_subtotal");
                                jumlah_potongan_subtotal.innerHTML = "- " + rupiah(<?php echo $jumlah_potongan_subtotal?>);

                                <?php if($ongkir != 0){ ?>
                                    let invoice_total_harga_produk_kirim = document.getElementById("invoice_total_harga_produk_kirim");
                                    let total_harga_produk_kirim = document.getElementById("total_harga_produk_kirim");
                                    let total_potongan_ongkir = document.getElementById("total_potongan_ongkir");
                                    
                                    <?php if($jumlah_claim_ongkos_kirim_voucher == 0){ ?>
                                        invoice_total_harga_produk_kirim.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan + $ongkir?>);
                                        total_harga_produk_kirim.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan + $ongkir?>);
                                        
                                        jumlah_potongan_subtotal.innerHTML = "- " + rupiah(<?php echo $jumlah_potongan_subtotal?>);
                                    <?php } ?>
                                    
                                    <?php
                                        if($jumlah_claim_ongkos_kirim_voucher > 0){
                                            
                                            $total_ongkir = $ongkir - $claim_ongkos_kirim_voucher->potongan;

                                            $total_potongan_ongkir = $ongkir;

                                            if($ongkir > $claim_ongkos_kirim_voucher->potongan){
                                                $total_potongan_ongkir = $claim_ongkos_kirim_voucher->potongan;
                                            }

                                            if($total_ongkir <= 0){
                                                $total_ongkir = 0;
                                            }
                                    ?>
                                            total_potongan_ongkir.innerHTML = "- " + rupiah(<?php echo $total_potongan_ongkir?>);
                                            
                                            invoice_total_harga_produk_kirim.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan + $total_ongkir?>);
                                            total_harga_produk_kirim.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan + $total_ongkir?>);

                                            jumlah_potongan_subtotal.innerHTML = "- " + rupiah(<?php echo $jumlah_potongan_subtotal?>);
                                    <?php } ?>

                                <?php } ?>

                                let invoice_total_harga_produk = document.getElementById("invoice_total_harga_produk");
                                invoice_total_harga_produk.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan?>);

                                let total_harga_produk = document.getElementById("total_harga_produk");
                                total_harga_produk.innerHTML = rupiah(<?php echo $total_harga_pembelian_keseluruhan?>);
                            </script>
                        @endif
                    
                        
                        @if($jumlah_claim_pembelian_voucher == 0)
                            <script>
                                const rupiah = (number)=>{
                                    return new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR"
                                    }).format(number);
                                }
                                
                                <?php if($ongkir != 0){ ?>
                                    let invoice_total_harga_produk_kirim = document.getElementById("invoice_total_harga_produk_kirim");
                                    let total_harga_produk_kirim = document.getElementById("total_harga_produk_kirim");
                                    let total_potongan_ongkir = document.getElementById("total_potongan_ongkir");

                                    <?php if($jumlah_claim_ongkos_kirim_voucher == 0){ ?>
                                        invoice_total_harga_produk_kirim.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian + $ongkir?>);
                                        total_harga_produk_kirim.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian + $ongkir?>);
                                    <?php } ?>
                                    <?php
                                        if($jumlah_claim_ongkos_kirim_voucher > 0){
                                            
                                            $total_ongkir = $ongkir - $claim_ongkos_kirim_voucher->potongan;
                                            
                                            $total_potongan_ongkir = $ongkir;
                                            
                                            if($ongkir > $claim_ongkos_kirim_voucher->potongan){
                                                $total_potongan_ongkir = $claim_ongkos_kirim_voucher->potongan;
                                            }

                                            if($total_ongkir <= 0){
                                                $total_ongkir = 0;
                                            }
                                    ?>
                                            total_potongan_ongkir.innerHTML = "- " + rupiah(<?php echo $total_potongan_ongkir?>);

                                            invoice_total_harga_produk_kirim.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian + $total_ongkir?>);
                                            total_harga_produk_kirim.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian + $total_ongkir?>);
                                    <?php } ?>
                                    
                                <?php } ?>

                                let invoice_total_harga_produk = document.getElementById("invoice_total_harga_produk");
                                invoice_total_harga_produk.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian ?>);

                                let total_harga_produk = document.getElementById("total_harga_produk");
                                total_harga_produk.innerHTML = rupiah(<?php echo $semua_total_harga_pembelian ?>);
                            </script>
                        @endif
                    @endforeach
                </div><!-- End .row -->
            </div><!-- .End .tab-pane -->
        </center>
    </body>
</html>

<script>
  window.addEventListener("load", window.print());
</script>


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
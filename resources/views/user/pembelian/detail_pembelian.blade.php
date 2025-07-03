@extends('user/layout/main_dash')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        padding-bottom: 5px;
    }
    
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        width:200%;
    }
</style>

@section('container')
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body" align="center">
                    <p class=""><b>
                        @if($purchases->kode_pembelian == "")

                        @else
                            {{$purchases->kode_pembelian}} - 
                        @endif
                        @if($profile->id == $purchases->user_id)
                            {{$profile->name}}
                        @endif
                    </b></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->

    @foreach($product_purchases as $invoice_product_purchases)
    @if ($invoice_product_purchases->type == 'supplier')
        <a href="../lihat_produk_supplier/{{$invoice_product_purchases->product_id}}" class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
    @else
        <a href="../lihat_produk/{{$invoice_product_purchases->product_id}}" class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
    @endif
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
        <div style="padding: 10px">
            <table style="padding: 10px">
                <tr>
                    <td valign="top">Catatan</td>
                    <td valign="top"> : &nbsp;</td>
                    <td> {{$purchases->catatan}} </td>
                </tr>
            </table>
        </div><br>
    @endif

    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status2" 
    || $purchases->status_pembelian == "status3" || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status5" )
        @if($cek_user_address > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                    <h3 class="card-title">Lokasi Pengiriman </h3>
                        <table>
                            <tr>
                                <td>Provinsi</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$user_address->province_name}} </td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$user_address->city_name}} </td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$user_address->subdistrict_name}} </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$user_address->user_street_address}} </td>
                            </tr>
                        </table>
                        <!-- <h6 class="">Alamat Pengiriman : <br><br> {{$purchases->alamat_purchase}}</h6> -->
                        <p></p>
                    </div><!-- End .card-body -->
                </div><!-- End .card-dashboard -->
            </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
        @elseif($cek_user_address == 0)

        @endif
    
    @elseif($purchases->status_pembelian == "status1_ambil" || $purchases->status_pembelian == "status2_ambil")
        @if($cek_merchant_address > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <h3 class="card-title">Lokasi Toko </h3>
                        <table>
                            <tr>
                                <td>Provinsi</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$merchant_address->province_name}} </td>
                            </tr>
                            <tr>
                                <td>Kota</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$merchant_address->city_name}} </td>
                            </tr>
                            <tr>
                                <td>Kecamatan</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$merchant_address->subdistrict_name}} </td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$merchant_address->merchant_street_address}} </td>
                            </tr>
                            <tr>
                                <td>Nama Toko</td>
                                <td>&emsp; : &emsp;</td>
                                <td> {{$merchant_info->nama_merchant}} </td>
                            </tr>
                        </table>
                    </div><!-- End .card-body -->
                </div><!-- End .card-dashboard -->
            </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
        @elseif($cek_merchant_address == 0)

        @endif

    @else

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
                        <tr>
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
                        <tr>
                            <td>Voucher Pembelian:</td>
                            <td><a id="jumlah_potongan_subtotal"></a></td>
                        </tr>
                        @endif

                        @if($invoice_jumlah_claim_ongkos_kirim_voucher > 0)
                        <tr>
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
                
                <button onclick="window.open('../invoice_pembelian/{{$purchases->purchase_id}}', '_blank')" class="btn btn-outline-primary btn-rounded" style="border-color: red; color: red; background-color: white;">
                    <span>Lihat Invoice</span>
                </button>
                
            </div><!-- End .summary -->
        </aside><!-- End .col-lg-3 -->
    </div><!-- End .row -->
    
    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status1_ambil")
        @if(!$cek_proof_of_payment)
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <p class="">
                            SILAHKAN LAKUKAN PEMBAYARAN PESANAN ANDA SENILAI
                            
                            @if($purchases->status_pembelian == "status1")
                            <b><a id="total_harga_produk_kirim"></a></b>
                            <!-- <b><a id="">-</a></b> -->
                            @elseif($purchases->status_pembelian == "status1_ambil")
                            <b><a id="total_harga_produk"></a></b>
                            @endif

                            KE NOMOR REKENING DIBAWAH INI.<br>
                            <!-- <center><b>081375215693 (DANA)</b> A/N <b>Riyanthi A Sianturi</b><center> -->

                            <center><b>1070018822454 (Mandiri)</b> A/N <b>Riyanthi A Sianturi</b><center>
                                
                            <!-- <center><b>7780086305 (BCA)</b> A/N <b>Timothy J F Henan</b><center> -->
                        </p>
                    </div><!-- End .card-body -->
                </div><!-- End .card-dashboard -->
            </div><!-- End .col-lg-6 -->
        </div><!-- End .row -->
        @elseif($cek_proof_of_payment)

        @endif
    @endif

    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status1_ambil" || $purchases->status_pembelian == "status2"
    || $purchases->status_pembelian == "status2_ambil" || $purchases->status_pembelian == "status3" || $purchases->status_pembelian == "status3_ambil"
    || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status4_ambil_a" || $purchases->status_pembelian == "status4_ambil_b"
    || $purchases->status_pembelian == "status5")
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    @if($purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status4_ambil_b"
                    || $purchases->status_pembelian == "status5" || $purchases->status_pembelian == "status5_ambil")
                        <p class="">Pesanan Diterima. PEMBELIAN BERHASIL.</p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status4_ambil_a")
                        <!-- <p class="">Pesanan telah diberikan.  SILAHKAN KONFIRMASI PESANAN.</p> -->
                        <p class="">SILAHKAN AMBIL DAN KONFIRMASI PESANAN ANDA.</p>
                    @endif

                    @if($purchases->status_pembelian == "status3")
                        <p class="">Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN SAMPAI.</p>
                        <p class="">SILAHKAN <a href="https://cekresi.com/?noresi={{$purchases->no_resi}}" target="_blank"><b>CEK</b></a> RESI MENGUNAKAN NOMOR RESI : <b>{{$purchases->no_resi}}</b> <a>[{{$courier_name}}]</a></p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status3_ambil")
                        <p class="">Pesanan Telah Disiapkan. SILAHKAN AMBIL PESANAN ANDA DI TOKO.</p>
                    @endif

                    @if($purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status2_ambil")
                        <p class="">Pesanan Sedang Diproses. TUNGGU PESANAN DIPROSES.</p>
                    @endif

                    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status1_ambil")
                        @if(!$cek_proof_of_payment)
                        <p class="">Belum Dapat Dikonfirmasi. KIRIM BUKTI PEMBAYARAN.</p>
                        
                        @elseif($cek_proof_of_payment)
                        <p class="">Bukti Pembayaran Telah Dikirim. MENUNGGU KONFIRMASI.</p>
                        @endif
                    @endif
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
    @endif

    @if($purchases->status_pembelian == "status3" || $purchases->status_pembelian == "status4_ambil_a")
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    @if($purchases->status_pembelian == "status3")
                    <p class="">Jika pesanan telah sampai di lokasi dan telah diterima. SILAHKAN KONFIRMASI PESANAN.</p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status4_ambil_a")
                    <p class="">Jika pesanan telah diambil. SILAHKAN KONFIRMASI</p>
                    @endif
                    
                    <a href="../update_status_pembelian/{{$purchases->purchase_id}}" class="btn btn-primary btn-round">
                        <span>KONFIRMASI</span>
                    </a>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
    @endif

    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status1_ambil")
        @if(!$cek_proof_of_payment)
        <form action="../PostBuktiPembayaran/{{$purchases->purchase_id}}" method="post" enctype="multipart/form-data" class="row" >
        @csrf
            <div class="col-lg-12">
                <div class="card card-dashboard">
                    <div class="card-body">
                        <div class="fileUpload">
                            <input id="uploadBtn1" type="file" name="proof_of_payment_image" class="upload" accept="image/*" required/>
                            <input class="form-control" id="uploadFile1" placeholder="Pilih Foto..." disabled="disabled"/>
                            <small class="form-text">Pastikan gambar yang anda masukkan dapat dilihat dengan jelas.</small>
                        </div>
                        <script>
                            document.getElementById("uploadBtn1").onchange = function () {
                                document.getElementById("uploadFile1").value = this.value;
                            };
                        </script>
                        <button type="submit" class="btn btn-outline-primary-2">
                            <span>KIRIM</span>
                        </button>
                    </div><!-- End .card-body -->
                </div><!-- End .card-dashboard -->
            </div><!-- End .col-lg-6 -->
        </form><!-- End .row -->
        
        @elseif($cek_proof_of_payment)

        @endif
    @endif

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

                    if($jumlah_potongan_subtotal < $claim_pembelian_voucher->maksimal_pemotongan){
                        $jumlah_potongan_subtotal = array_sum($potongan_subtotal);
                    }
            
                    else if($jumlah_potongan_subtotal >= $claim_pembelian_voucher->maksimal_pemotongan){
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


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


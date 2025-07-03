@extends('user/toko/layout/main')

@section('title', 'Rumah Kreatif Toba - Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Toko</li>
@endsection

@section('container')

@if($purchases->status_pembelian == "status1")

@else
<div class="tab-pane fade show active" id="tab-toko" role="tabpanel" aria-labelledby="tab-toko-link">
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
                            {{$profile->name}} ({{$profile->username}})
                        @endif
                    </b></p>
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->

    @foreach($product_purchases as $product_purchases)
        @if ($product_purchases->type == 'supplier')
            <a href="../edit_produk_supplier/{{$product_purchases->product_id}}" class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
        @else
            <a href="../edit_produk/{{$product_purchases->product_id}}" class="col-lg-12 border mb-1 row" style="padding: 15px 0px 15px 0px; margin: 0px">
        @endif
            <?php
                $product_image = DB::table('product_images')->select('product_image_name')->where('product_id', $product_purchases->product_id)->orderBy('product_image_id', 'asc')->first();
            ?>

            <div class="col-md-2"  align="center">
                <img src="../asset/u_file/product_image/{{$product_image->product_image_name}}" class="img-fluid" alt="{{$product_image->product_image_name}}" width="50px">
            </div>
            
            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">{{$product_purchases->product_name}}</p>
            </div>
            
            <?php
                $jumlah_product_specifications = DB::table('product_specifications')->where('product_id', $product_purchases->product_id)->count();
            ?>
            @if($jumlah_product_specifications == 0)

            @else
                @foreach($product_specifications as $product_specification)
                    @if($product_specification->product_id == $product_purchases->product_id)
                    <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0">{{$product_specification->nama_spesifikasi}}</p>
                    </div>
                    @endif
                @endforeach
            @endif

            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <p class="text-muted mb-0">Jumlah: {{$product_purchases->jumlah_pembelian_produk}}</p>
            </div>

            <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                <?php
                    if($product_purchases->harga_pembelian_produk == null){
                        $harga_produk = "Rp." . number_format(floor($product_purchases->price * $product_purchases->jumlah_pembelian_produk),0,',','.');
                    }
                    
                    else if($product_purchases->harga_pembelian_produk != null){
                        $harga_produk = "Rp." . number_format(floor($product_purchases->harga_pembelian_produk),0,',','.');
                    }
                    // $harga_produk = "Rp " . number_format($product_purchases->price*$product_purchases->jumlah_pembelian_produk * $product_purchases->jumlah_pembelian_produk,0,',','.');
                ?>
                <p class="text-muted mb-0">{{$harga_produk}}</p>
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
    
    @if($purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status3" 
        || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status5" )
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
                                <tr>
                                    <td>Nomor Telepon</td>
                                    <td>&emsp; : &emsp;</td>
                                    <td> 
                                        @if($profile->id == $purchases->user_id)
                                            {{$profile->no_hp}}
                                        @endif
                                    </td>
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
                        </tr>

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
                        
                        <tr class="summary-total">
                            <td>Total:</td>
                            <td>
                                <?php
                                    if($purchases->harga_pembelian == null){
                                        $invoice_total_pembelian = $total_harga->total_harga + $ongkir;
                                    }

                                    else if($purchases->harga_pembelian != null){
                                        $invoice_total_pembelian = $purchases->harga_pembelian + $ongkir;
                                    }

                                    $invoice_total_pembelian_fix = "Rp." . number_format($invoice_total_pembelian,2,',','.');
                                ?>
                                <a>{{$invoice_total_pembelian_fix}}</a>
                            </td>
                        </tr><!-- End .summary-total -->
                    </tbody>
                </table><!-- End .table table-summary -->
                
                <button onclick="window.open('../invoice_penjualan/{{$purchases->purchase_id}}', '_blank')" class="btn btn-outline-primary btn-rounded" style="border-color: red; color: red; background-color: white;">
                    <span>Lihat Invoice</span>
                </button>
            </div><!-- End .summary -->
        </aside><!-- End .col-lg-3 -->
    </div><!-- End .row -->

    @if($purchases->status_pembelian == "status3")
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    <p class="">SILAHKAN <a href="https://cekresi.com/?noresi={{$purchases->no_resi}}" target="_blank"><b>CEK</b></a> RESI MENGUNAKAN NOMOR RESI : <b>{{$purchases->no_resi}}</b> <a>[{{$courier_name}}]</a></p>
                    <p><b>ATAU</b></p>
                    <p class="">UPDATE NOMOR RESI.</p>
                    <form action="../update_no_resi/{{$purchases->purchase_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="text" name="no_resi" class="form-control form-control-rounded" placeholder="Nomor Resi" required>
                        <button type="submit" class="btn btn-primary btn-round"><span>EDIT</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    @if($purchases->status_pembelian == "status5" || $purchases->status_pembelian == "status5_ambil")
                        <p class="">Penjualan Telah Dibayar. PENJUALAN BERHASIL.</p>
                    @endif

                    @if($purchases->status_pembelian == "status4")
                        <?php
                            $total_harga_status4 = "Rp." . number_format(floor((int)$total_harga->total_harga + $ongkir),0,',','.');
                        ?>
                        <p class="">
                            Pembelian Berhasil. SILAHKAN TUNGGU BAYARAN. 
                            <b><a id="total_harga_produk"></a>{{$total_harga_status4}}</b>    
                            DIKIRIM KE REKENING YANG TELAH TOKO DAFTARKAN.
                        </p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status4_ambil_a")
                        <!-- <p class="">TUNGGU PELANGGAN MENGKONFIRMASI PESANAN YANG TELAH DIAMBIL.</p> -->
                        <p class="">TUNGGU PELANGGAN MENGAMBIL DAN MENGKONFIRMASI PESANAN.</p>
                    @endif
                        
                    @if($purchases->status_pembelian == "status4_ambil_b")
                        <?php
                            $total_pembelian = $total_harga->total_harga + $ongkir;
                            $total_pembelian_fix = "Rp." . number_format(floor((int)$total_pembelian),2,',','.');
                        ?>
                        <p class="">
                            Pembelian Berhasil. SILAHKAN TUNGGU BAYARAN SENILAI 
                            <b><a id="total_harga_produk">{{$total_pembelian_fix}}</a></b>    
                            DIKIRIM KE REKENING YANG TELAH TOKO DAFTARKAN.
                        </p>
                    @endif

                    @if($purchases->status_pembelian == "status3")
                        <p class="">Pesanan Sedang Dalam Perjalanan. TUNGGU PESANAN DITERIMA.</p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status3_ambil")
                        <p class="">SILAHKAN TUNGGU PELANGGAN MENGAMBIL PESANAN.</p>
                    @endif

                    @if($purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status2_ambil")
                        <p class="">Ada Pesanan. SILAHKAN PROSES PESANAN.</p>
                    @endif

                    @if($purchases->status_pembelian == "status1" || $purchases->status_pembelian == "status1")
                    
                    @endif
                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->

    @if($purchases->status_pembelian == "status2" || $purchases->status_pembelian == "status2_ambil"
    || $purchases->status_pembelian == "status3_ambil" || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status4_ambil_b")
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-dashboard">
                <div class="card-body">
                    @if($purchases->status_pembelian == "status2")
                    <p class="">Jika pesanan telah dikirim dan sedang dalam perjalanan.</p>
                    <p class="">SILAHKAN GUNAKAN KIRIM MELALUI <b>{{$courier_name}} - {{$service_name}}</b> UNTUK PESANAN.</p>
                    <p class="">MASUKAN NOMOR RESI. KEMUDIAN SILAHKAN KONFIRMASI PESANAN.</p>
                    
                    <form action="../update_status2_pembelian/{{$purchases->purchase_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                        <input type="text" name="no_resi" class="form-control" placeholder="Nomor Resi" required>
                        
                        <button type="submit" class="btn btn-primary btn-round"><span>KIRIM</span></button>
                    </form>
                    @endif
                    
                    @if($purchases->status_pembelian == "status2_ambil")
                    <p class="">Jika pesanan telah disiapkan. SILAHKAN KONFIRMASI PESANAN.</p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status3_ambil")
                    <p class="">Jika pesanan telah diambil pelanggan. SILAHKAN KONFIRMASI PESANAN.</p>
                    @endif
                    
                    @if($purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status4_ambil_b")
                    <p class="">Jika bayaran telah diterima. SILAHKAN KONFIRMASI.</p>
                    @endif

                    @if($purchases->status_pembelian == "status2_ambil" || $purchases->status_pembelian == "status3_ambil"
                    || $purchases->status_pembelian == "status4" || $purchases->status_pembelian == "status4_ambil_b")
                        <a href="../update_status_pembelian/{{$purchases->purchase_id}}" class="btn btn-outline-primary-2">
                            <span>KONFIRMASI</span>
                        </a>
                    @endif

                </div><!-- End .card-body -->
            </div><!-- End .card-dashboard -->
        </div><!-- End .col-lg-6 -->
    </div><!-- End .row -->
    @endif
</div><!-- .End .tab-pane -->

@endif


<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>
@endsection


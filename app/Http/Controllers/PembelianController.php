<?php

namespace App\Http\Controllers;

use App\Models\PemesananRental;
use App\Models\PemesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

use Carbon\Carbon;
use App\Notifications\ProductPurchasedNotification;
use App\Models\User;

class PembelianController extends Controller
{
    public function checkout($merchant_id) {
        date_default_timezone_set('Asia/Jakarta');

        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }

        $user_id = Auth::user()->id;

        $product_id = $_POST['product_id'];

        $jumlah_dipilih = count($product_id);

        for($x=0; $x<$jumlah_dipilih; $x++){
            $product = DB::table('products')->where('product_id', $product_id[$x])->first();
            $stocks = DB::table('stocks')->where('product_id', $product_id[$x])->first();
            if($stocks->stok > 0){
                $jumlah_masuk_keranjang = $_POST['jumlah_masuk_keranjang'];
                DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_id[$x])->update([
                    'jumlah_masuk_keranjang' => $jumlah_masuk_keranjang[$x],
                ]);
            }

            else if($stocks->stok == 0){
                DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_id[$x])->delete();
            }
        }

        $cek_cart = DB::table('carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->count();

        $cek_cart_jasa = DB::table('service_carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('services', 'service_carts.service_id', '=', 'services.service_id')->count();

        $carts = DB::table('carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->get();

        $service_carts = DB::table('service_carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('services', 'service_carts.service_id', '=', 'services.service_id')->get();

        $total_harga = DB::table('carts')->select(DB::raw('SUM(price * jumlah_masuk_keranjang) as total_harga'))->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('products', 'carts.product_id', '=', 'products.product_id')->first();

        $total_harga_jasa = DB::table('service_carts')->select(DB::raw('SUM(price * jumlah_masuk_keranjang) as total_harga'))->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('services', 'service_carts.service_id', '=', 'services.service_id')->first();


        // foreach($carts as $cek_cart_voucher){
        //     $cek_pembelian_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        //     ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<', $total_harga->total_harga)
        //     ->where('target_kategori', $cek_cart_voucher->category_id)->where('tipe_voucher', "pembelian")
        //     ->orderBy('nama_voucher', 'asc')->count();

        // }

        $get_pembelian_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<=', $total_harga->total_harga)
        ->where('tipe_voucher', "pembelian")->orderBy('nama_voucher', 'asc')->get();

        $cek_ongkos_kirim_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<=', $total_harga->total_harga)
        ->where('tipe_voucher', "ongkos_kirim")->orderBy('nama_voucher', 'asc')->count();

        $get_ongkos_kirim_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<=', $total_harga->total_harga)
        ->where('tipe_voucher', "ongkos_kirim")->orderBy('nama_voucher', 'asc')->get();

        $jumlah_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku','<=',date('Y-m-d'))
        ->where('tanggal_batas_berlaku','>=',date('Y-m-d'))->count();

        $vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->orderBy('nama_voucher', 'asc')->get();

        $ongkos_kirim_vouchers = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('tipe_voucher', "ongkos_kirim")->orderBy('nama_voucher', 'asc')->get();

        $total_berat = DB::table('carts')->select(DB::raw('SUM(heavy * jumlah_masuk_keranjang) as total_berat'))->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->first();

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_id)->first();

        $user_address = DB::table('user_address')->where('user_id', $user_id)->where('is_deleted', 0)->orderBy('subdistrict_id', 'asc')->get();

        $metode_pembelian = null;

        return view('user.pembelian.checkout')->with('merchant_id', $merchant_id)->with('cek_cart', $cek_cart)->with('cek_cart_jasa', $cek_cart_jasa)->with('carts', $carts)->with('service_carts', $service_carts)
        ->with('jumlah_vouchers', $jumlah_vouchers)->with('vouchers', $vouchers)->with('ongkos_kirim_vouchers', $ongkos_kirim_vouchers)
        ->with('total_harga', $total_harga)->with('total_harga_jasa', $total_harga_jasa)->with('total_berat', $total_berat)
        ->with('merchant_address', $merchant_address)->with('user_address', $user_address)->with('get_pembelian_vouchers', $get_pembelian_vouchers)
        ->with('cek_ongkos_kirim_vouchers', $cek_ongkos_kirim_vouchers)->with('get_ongkos_kirim_vouchers', $get_ongkos_kirim_vouchers)
        ->with('metode_pembelian', $metode_pembelian);
    }

    public function checkout_jasa($merchant_id) {
        date_default_timezone_set('Asia/Jakarta');

        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }

        $user_id = Auth::user()->id;

        $service_id = $_POST['service_id'];

        $cek_cart_jasa = DB::table('service_carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('services', 'service_carts.service_id', '=', 'services.service_id')->count();

        $service_carts = DB::table('service_carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('services', 'service_carts.service_id', '=', 'services.service_id')->get();

        $total_harga_jasa = DB::table('service_carts')->select(DB::raw('SUM(price * jumlah_masuk_keranjang) as total_harga'))->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('services', 'service_carts.service_id', '=', 'services.service_id')->first();

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_id)->first();
        $user_address = DB::table('user_address')->where('user_id', $user_id)->where('is_deleted', 0)->orderBy('subdistrict_id', 'asc')->get();

        $metode_pembelian = null;

        return view('user.pembelian.checkout_jasa')->with('merchant_id', $merchant_id)->with('cek_cart_jasa', $cek_cart_jasa)->with('service_carts', $service_carts)
        ->with('total_harga_jasa', $total_harga_jasa)
        ->with('merchant_address', $merchant_address)->with('user_address', $user_address);
    }

    public function ambil_voucher_pembelian() {
        $user_id = Auth::user()->id;
        $voucher = $_GET['voucher'];
        $merchant_id = $_GET['merchant_id'];
        $total_harga_checkout = $_GET['total_harga_checkout'];

        $voucher_dipilih = DB::table('vouchers')->where('voucher_id', $voucher)->first();

        $target_metode_pembelian = $voucher_dipilih->target_metode_pembelian;

        $target_kategori = explode(",", $voucher_dipilih->target_kategori);


        foreach($target_kategori as $target_kategori){
            $subtotal_harga_produk = DB::table('carts')->select(DB::raw('SUM(price * jumlah_masuk_keranjang) as subtotal_harga_produk'))->where('category_id', $target_kategori)
            ->where('user_id', $user_id)->where('merchant_id', $merchant_id)->join('products', 'carts.product_id', '=', 'products.product_id')->first();

            $potongan_subtotal[] = (int)$subtotal_harga_produk->subtotal_harga_produk * $voucher_dipilih->potongan / 100;
        }

        $jumlah_potongan_subtotal = array_sum($potongan_subtotal);

        if($jumlah_potongan_subtotal <= $voucher_dipilih->maksimal_pemotongan){
            $potongan = $jumlah_potongan_subtotal;
        }

        else if($jumlah_potongan_subtotal > $voucher_dipilih->maksimal_pemotongan){
            $potongan = $voucher_dipilih->maksimal_pemotongan;
        }

        $total_harga_fix = (int)$total_harga_checkout - $potongan;

        $total_harga_checkout = "Rp." . number_format($total_harga_fix,0,',','.');

        return response()->json(compact(['potongan', 'target_metode_pembelian']));
    }

    public function ambil_voucher_ongkos_kirim() {
        $user_id = Auth::user()->id;
        $voucher_ongkir = $_GET['voucher_ongkir'];

        $voucher_dipilih = DB::table('vouchers')->where('voucher_id', $voucher_ongkir)->first();

        $potongan = $voucher_dipilih->potongan;

        return response()->json($potongan);
    }

    public function pilih_metode_pembelian(Request $request) {
        $tipe = $_GET['tipe'];

        $merchant_id = $_GET['merchant_id'];

        $foreach_option_voucher = "";
        $option_voucher = "";

        $user_id = Auth::user()->id;

        $total_harga = DB::table('carts')->select(DB::raw('SUM(price * jumlah_masuk_keranjang) as total_harga'))->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('products', 'carts.product_id', '=', 'products.product_id')->first();

        $get_pembelian_vouchers_ambil_ditempat = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<=', $total_harga->total_harga)
        ->where('tipe_voucher', "pembelian")
        ->where(function($query){
            $query->where('target_metode_pembelian', "ambil_ditempat")
                  ->orWhere('target_metode_pembelian', null);
        })
        ->orderBy('nama_voucher', 'asc')->get();

        $get_pembelian_vouchers_pesanan_dikirim = DB::table('vouchers')->where('is_deleted', 0)->where('tanggal_berlaku', '<=', date('Y-m-d'))
        ->where('tanggal_batas_berlaku', '>=', date('Y-m-d'))->where('minimal_pengambilan', '<=', $total_harga->total_harga)
        ->where('tipe_voucher', "pembelian")
        ->where(function($query){
            $query->where('target_metode_pembelian', "pesanan_dikirim")
                  ->orWhere('target_metode_pembelian', null);
        })
        ->orderBy('nama_voucher', 'asc')->get();

        $carts = DB::table('carts')->where('user_id', $user_id)->where('merchant_id', $merchant_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->get();

        if($tipe == "ambil_ditempat"){
            $get_pembelian_vouchers = $get_pembelian_vouchers_ambil_ditempat;

            if ($get_pembelian_vouchers_ambil_ditempat->isEmpty()) {

            }

            else{
                foreach($get_pembelian_vouchers as $pembelian_voucher){
                    $get_target_kategori = explode(
                        ',',
                        $pembelian_voucher->target_kategori
                    );

                    $cek_get_target_kategori_voucher = 0;

                    foreach($carts as $carts2){
                        foreach($get_target_kategori as $target_kategori){
                            if($target_kategori == $carts2->category_id && $cek_get_target_kategori_voucher != $pembelian_voucher->voucher_id){
                                $option_voucher.="
                                    <option value='$pembelian_voucher->voucher_id'>$pembelian_voucher->nama_voucher ($pembelian_voucher->potongan%)</option>
                                ";

                                $cek_get_target_kategori_voucher = $pembelian_voucher->voucher_id;
                            }
                        }
                    }
                }

                $foreach_option_voucher.="
                    <option value='' disabled selected>Pilih Voucher Pembelian</option>
                    $option_voucher
                ";
            }
        }

        elseif($tipe == "pesanan_dikirim"){
            $get_pembelian_vouchers = $get_pembelian_vouchers_pesanan_dikirim;

            if ($get_pembelian_vouchers_pesanan_dikirim->isEmpty()) {

            }

            else{
                foreach($get_pembelian_vouchers as $pembelian_voucher){
                    $get_target_kategori = explode(
                        ',',
                        $pembelian_voucher->target_kategori
                    );

                    $cek_get_target_kategori_voucher = 0;

                    foreach($carts as $carts2){
                        foreach($get_target_kategori as $target_kategori){
                            if($target_kategori == $carts2->category_id && $cek_get_target_kategori_voucher != $pembelian_voucher->voucher_id){
                                $option_voucher.="
                                    <option value='$pembelian_voucher->voucher_id'>$pembelian_voucher->nama_voucher ($pembelian_voucher->potongan%)</option>
                                ";

                                $cek_get_target_kategori_voucher = $pembelian_voucher->voucher_id;
                            }
                        }
                    }
                }

                $foreach_option_voucher.="
                    <option value='' disabled selected>Pilih Voucher Pembelian</option>
                    $option_voucher
                ";
            }
        }

        return response()->json(compact(['tipe', 'foreach_option_voucher', 'get_pembelian_vouchers_ambil_ditempat',
            'get_pembelian_vouchers_pesanan_dikirim']));
    }

    public function ambil_jalan(Request $request) {
        $curl = curl_init();

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $_GET['merchant_id'])->first();

        $user_id = Auth::user()->id;
        $user_address_id = $_GET['id'];
        $user_address = DB::table('user_address')->where('user_id', $user_id)->where('user_address_id', $user_address_id)->first();
        $param = $user_address->city_id;
        $subdistrict_id = $user_address->subdistrict_id;

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$param,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
        ));

        $response = curl_exec($curl);
        $collection = json_decode($response, true);
        $filters =  array_filter($collection['rajaongkir']['results'], function($r) use ($subdistrict_id) {
            return $r['subdistrict_id'] == $subdistrict_id;
        });

        foreach ($filters as $filter){
            $filtered = $filter;
        }

        $err = curl_error($curl);
        curl_close($curl);

        $shipping_local = DB::table('shipping_locals')->where('merchant_id', $_GET['merchant_id'])
        ->where('shipping_local_subdistrict_id', $subdistrict_id)->first();

        return response()->json(compact(['filtered', 'shipping_local', 'merchant_address']));

        // return response()->json($filtered);
    }

    public function cek_ongkir(Request $request)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$request->origin&originType=$request->originType&destination=$request->destination&destinationType=$request->destinationType&weight=$request->weight&courier=$request->courier",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: 41df939eff72c9b050a81d89b4be72ba"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        return response()->json($response);
    }

    public function PostBeliProduk(Request $request) {
        date_default_timezone_set('Asia/Jakarta');

        $user_id = Auth::user()->id;

        $kode_pembelian = 'rkt_'.time();

        $catatan = $request -> catatan;

        $merchant_id = $request -> merchant_id;

        $voucher_pembelian = $request -> voucher_pembelian;
        $voucher_ongkos_kirim = $request -> voucher_ongkos_kirim;

        $metode_pembelian = $request -> metode_pembelian;

        $harga_pembelian = $request -> harga_pembelian;
        $potongan_pembelian = $request -> potongan_pembelian;

        $alamat_purchase = $request -> alamat_purchase;

        $courier_code = $request -> courier;
        $service = $request -> service;

        DB::table('checkouts')->insert([
            'user_id' => $user_id,
            'catatan' => $catatan,
        ]);

        $checkout_id = DB::table('checkouts')->select('checkout_id')->orderBy('checkout_id', 'desc')->first();

        if($voucher_pembelian){
            DB::table('claim_vouchers')->insert([
                'checkout_id' => $checkout_id->checkout_id,
                'voucher_id' => $voucher_pembelian,
            ]);
        }

        if($voucher_ongkos_kirim){
            DB::table('claim_vouchers')->insert([
                'checkout_id' => $checkout_id->checkout_id,
                'voucher_id' => $voucher_ongkos_kirim,
            ]);
        }

        if($metode_pembelian == "ambil_ditempat"){
            DB::table('purchases')->insert([
                'kode_pembelian' => $kode_pembelian,
                'user_id' => $user_id,
                'checkout_id' => $checkout_id->checkout_id,
                'alamat_purchase' => "",
                'harga_pembelian' => $harga_pembelian,
                'potongan_pembelian' => $potongan_pembelian,
                'status_pembelian' => "status1_ambil",
                'ongkir' => 0,
                'is_cancelled' => 0,
                'is_deleted' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        if($metode_pembelian == "pesanan_dikirim"){
            $ongkir = $request -> ongkir;
            DB::table('purchases')->insert([
                'kode_pembelian' => $kode_pembelian,
                'user_id' => $user_id,
                'checkout_id' => $checkout_id->checkout_id,
                'alamat_purchase' => $alamat_purchase,
                'harga_pembelian' => $harga_pembelian,
                'potongan_pembelian' => $potongan_pembelian,
                'status_pembelian' => "status1",
                'courier_code' => $courier_code,
                'service' => $service,
                'ongkir' => $ongkir,
                'is_cancelled' => 0,
                'is_deleted' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }


        $purchase_id = DB::table('purchases')->select('purchase_id')->orderBy('purchase_id', 'desc')->first();

        $product_purchase = DB::table('carts')->select('carts.product_id', 'heavy', 'jumlah_masuk_keranjang', 'price')->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('products', 'carts.product_id', '=', 'products.product_id')->get();

        foreach($product_purchase as $product_purchase){
            DB::table('product_purchases')->insert([
                'purchase_id' => $purchase_id->purchase_id,
                'product_id' => $product_purchase->product_id,
                'berat_pembelian_produk' => $product_purchase->jumlah_masuk_keranjang * $product_purchase->heavy,
                'jumlah_pembelian_produk' => $product_purchase->jumlah_masuk_keranjang,
                'harga_pembelian_produk' => $product_purchase->jumlah_masuk_keranjang * $product_purchase->price,
            ]);

            $stok = DB::table('stocks')->select('stok')->where('product_id', $product_purchase->product_id)->first();

            DB::table('stocks')->where('product_id', $product_purchase->product_id)->update([
                'stok' => $stok->stok - $product_purchase->jumlah_masuk_keranjang,
            ]);

            DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_purchase->product_id)->delete();
        }

        return redirect("../detail_pembelian/$purchase_id->purchase_id");
    }

    public function PostBeliJasa(Request $request) {
        date_default_timezone_set('Asia/Jakarta');

        $user_id = Auth::user()->id;

        $kode_pembelian = 'rkt_'.time();

        $merchant_id = $request -> merchant_id;

        $address = $request -> address;
        $phone_number = $request -> phone_number;
        $start_date = $request -> start_date;
        $end_date = $request -> end_date;
        $note = $request -> note;

        DB::table('checkouts')->insert([
            'user_id' => $user_id,
        ]);

        $checkout_id = DB::table('checkouts')->select('checkout_id')->orderBy('checkout_id', 'desc')->first();

        $bookings = DB::table('service_carts')->select('service_carts.service_id', 'jumlah_masuk_keranjang', 'price')->where('user_id', $user_id)
        ->where('merchant_id', $merchant_id)->join('services', 'service_carts.service_id', '=', 'services.service_id')->get();

        foreach($bookings as $booking){
            DB::table('service_booking')->insert([
                'user_id' => $user_id,
                'service_id' => $booking->service_id,
                'address' => $address,
                'phone_number' => $phone_number,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'notes' => $note,
                'status' => "waiting",
                'checkout_id' => $checkout_id->checkout_id,
            ]);

            // DB::table('service_carts')->where('user_id', $user_id)->where('service_id', $service)->delete();
        }

        return redirect('../daftar_pembelian');
    }

    public function daftar_pembelian() {
        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }

        if(Session::get('toko')){
            $toko = Session::get('toko');

            $purchases = DB::table('product_purchases')->select('product_purchases.purchase_id', 'kode_pembelian', 'status_pembelian', 'name', 'username', 'purchases.created_at')->where('merchant_id', $toko)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('profiles', 'purchases.user_id', '=', 'profiles.user_id')->join('users', 'purchases.user_id', '=', 'users.id')
            ->orderBy('product_purchases.purchase_id', 'desc')->groupBy('purchase_id', 'kode_pembelian', 'status_pembelian', 'name', 'username', 'purchases.created_at')->get();

            $service_booking = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $service_booking_waiting = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)->where('status', 'waiting')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $service_booking_approved = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)->where('status', 'approved')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $service_booking_on_progress = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)->where('status', 'on progress')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $service_booking_declined = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)->where('status', 'declined')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $service_booking_done = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('merchant_id', $toko)->where('status', 'done')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')
            ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
            ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

            $jumlah_purchases = DB::table('product_purchases')->where('merchant_id', $toko)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('purchase_id')->count();

            $jumlah_booking = DB::table('service_booking')->where('merchant_id', $toko)
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')->groupBy('service_booking.id')->count();

            $product_purchases = DB::table('product_purchases')->where('merchant_id', $toko)->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

            $product_specifications = DB::table('product_specifications')
            ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
            ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
            ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

            $count_proof_of_payment = DB::table('proof_of_payments')->select(DB::raw('COUNT(*) as count_proof_of_payment'))->first();

            $proof_of_payments = DB::table('proof_of_payments')->get();

            return view('user.toko.daftar_pembelian')->with('purchases', $purchases)->with('jumlah_purchases', $jumlah_purchases)
            ->with('product_purchases', $product_purchases)->with('product_specifications', $product_specifications)
            ->with('proof_of_payments', $proof_of_payments)->with('count_proof_of_payment', $count_proof_of_payment)
            ->with('service_booking', $service_booking)->with('service_booking_waiting', $service_booking_waiting)->with('service_booking_approved', $service_booking_approved)->with('service_booking_on_progress', $service_booking_on_progress)->with('service_booking_declined', $service_booking_declined)->with('service_booking_done', $service_booking_done)
            ->with('jumlah_booking', $jumlah_booking);
        }

        else{
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->whereIn('is_admin', [1, 2])->first();

            if($cek_admin_id){
                $data = DB::table("purchases as p")
                    ->join("profiles", "profiles.user_id", "=", "p.user_id")
                    ->joinSub(DB::table("product_purchases as pp")
                        ->join("products as p", "pp.product_id", "p.product_id")
                        ->join("merchants as m", "m.merchant_id", "p.merchant_id")
                        ->select("pp.purchase_id", "m.nama_merchant"), "mp", function($join){
                            $join->on("p.purchase_id", "=", "mp.purchase_id");
                        })
                    ->leftJoin("proof_of_payments as ppp", "ppp.purchase_id", "=", "p.purchase_id")
                    ->select("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian","ppp.proof_of_payment_image")
                    ->where('p.is_cancelled', 0)->where('p.is_deleted', 0)
                    ->groupBy("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian", "ppp.proof_of_payment_image")
                    ->get();

                $data_service_purchases = DB::table("service_purchases as sp")
                ->join("service_booking as sb", "sb.id", "=", "sp.service_booking_id")
                ->join("services as s", "s.service_id", "=", "sb.service_id")
                ->join("merchants as m", "m.merchant_id", "=", "s.merchant_id")
                ->join("proof_of_service_payments as psp", "psp.service_booking_id", "=", "sb.id")
                ->select('*', 'sp.status as service_purchase_status', 'sb.id as service_booking_id')
                ->first();

                return view('admin.daftar_pembelian', [
                    "purchases"=> $data,
                    "cek_admin_id"=> $cek_admin_id,
                    "service_purchase" => $data_service_purchases
                ]);
            }

            else{
                $checkouts = DB::table('checkouts')->where('user_id', $user_id)
                ->join('users', 'checkouts.user_id', '=', 'users.id')->orderBy('checkout_id', 'desc')->get();

                $claim_vouchers = DB::table('claim_vouchers')->where('tipe_voucher', 'pembelian')->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->get();

                $cek_purchases = DB::table('purchases')->where('user_id', $user_id)->first();
                $cek_service_booking = DB::table('service_booking')->where('user_id', $user_id)->first();

                $purchases = DB::table('purchases')->select("purchases.*")->where('user_id', $user_id)->where('is_cancelled', 0)
                ->join('users', 'purchases.user_id', '=', 'users.id')->orderBy('purchase_id', 'desc')->get();

                $service_booking = DB::table('service_booking')->select('*','service_booking.id as id')
                ->where('user_id', $user_id)
                ->join('users', 'service_booking.user_id', '=', 'users.id')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')->orderBy('service_booking.id', 'desc')->get();

                $service_booking_waiting = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('status', 'waiting')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

                $service_booking_approved = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'service_booking.status as status', 'service_purchases.status as purchase_status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('service_booking.status', 'approved')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->leftjoin('service_purchases', 'service_booking.id', '=', 'service_purchases.service_booking_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'service_booking.status', 'service_purchases.status', 'name', 'username')->get();

                $service_booking_on_progress = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'service_booking.status as status', 'service_purchases.status as purchase_status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('service_booking.status', 'on progress')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->leftjoin('service_purchases', 'service_booking.id', '=', 'service_purchases.service_booking_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'service_booking.status', 'service_purchases.status', 'name', 'username')->get();

                $service_booking_payment_validation = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'service_purchases.status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('service_purchases.status', 'on progress')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->leftjoin('service_purchases', 'service_booking.id', '=', 'service_purchases.service_booking_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

                $service_booking_declined = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('status', 'declined')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

                $service_booking_done = DB::table('service_booking')->select('services.price', 'services.service_name','service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->where('service_booking.user_id', $user_id)->where('status', 'done')
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')
                ->join('profiles', 'service_booking.user_id', '=', 'profiles.user_id')->join('users', 'service_booking.user_id', '=', 'users.id')
                ->orderBy('service_booking.service_id', 'desc')->groupBy('services.price', 'service_name', 'service_booking.id', 'service_booking.service_id', 'status', 'name', 'username')->get();

                $jumlah_booking = DB::table('service_booking')->where('merchant_id', $user_id)
                ->join('services', 'service_booking.service_id', '=', 'services.service_id')->groupBy('service_booking.id')->count();

                $cancelled_purchases = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 1)
                ->join('users', 'purchases.user_id', '=', 'users.id')->orderBy('purchase_id', 'desc')->get();

                $profile = DB::table('profiles')->where('user_id', $user_id)
                ->join('users', 'profiles.user_id', '=', 'users.id')->first();

                $product_purchases = DB::table('product_purchases')->where('user_id', $user_id)
                ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

                $product_specifications = DB::table('product_specifications')
                ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
                ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
                ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

                $count_proof_of_payment = DB::table('proof_of_payments')->select(DB::raw('COUNT(*) as count_proof_of_payment'))->first();

                return view('user.pembelian.daftar_pembelian')->with('checkouts', $checkouts)->with('claim_vouchers', $claim_vouchers)
                ->with('purchases', $purchases)->with('cancelled_purchases', $cancelled_purchases)->with('cek_purchases', $cek_purchases)->with('product_purchases', $product_purchases)->with('profile', $profile)
                ->with('product_specifications', $product_specifications)->with('count_proof_of_payment', $count_proof_of_payment)->with('cek_service_booking', $cek_service_booking)->with('jumlah_booking', $jumlah_booking)
                ->with('service_booking', $service_booking)->with('service_booking_waiting', $service_booking_waiting)->with('service_booking_approved', $service_booking_approved)->with('service_booking_on_progress', $service_booking_on_progress)->with('service_booking_payment_validation', $service_booking_payment_validation)->with('service_booking_declined', $service_booking_declined)->with('service_booking_done', $service_booking_done)
                ->with('cek_admin_id', $cek_admin_id);
            }
        }
    }

    public function detail_purchase(Request $request, $id){
        $purchase = null;
        $purchase = DB::table("purchases")->where("purchase_id", $id)
            ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')
            ->first();

        $products = null;
        $products = DB::table("product_purchases as pp")
            ->join("products as p", "pp.product_id", "=", "p.product_id")
            ->where("purchase_id", $id)
            ->get();

        $claim_pembelian_voucher = null;
        $claim_pembelian_voucher = DB::table('claim_vouchers')
            ->where('tipe_voucher', 'pembelian')->where('purchase_id', $id)
            ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')
            ->join('purchases', 'claim_vouchers.checkout_id', '=', 'purchases.checkout_id')
            ->first();

        $target_kategori = null;

        $subtotal_harga_produk = null;
        $potongan_subtotal = null;
        $subtotal_harga_produk_terkait = null;
        $subtotal_harga_produk_terkait_seluruh = null;
        $jumlah_potongan_subtotal = null;

        if($claim_pembelian_voucher){
            $target_kategori = explode(",", $claim_pembelian_voucher->target_kategori);

            foreach($target_kategori as $target_kategori_subtotal){
                $subtotal_harga_produk = DB::table('product_purchases')
                ->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
                ->where('purchases.purchase_id', $id)->where('category_id', $target_kategori_subtotal)
                ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
                ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

                $potongan_subtotal[] = (int)$subtotal_harga_produk->total_harga_pembelian * $claim_pembelian_voucher->potongan / 100;

                $subtotal_harga_produk_terkait[] = (int)$subtotal_harga_produk->total_harga_pembelian;
            }

            $subtotal_harga_produk_terkait_seluruh = array_sum($subtotal_harga_produk_terkait);


            if($purchase->potongan_pembelian != null){
                $jumlah_potongan_subtotal = $purchase->potongan_pembelian;
            }

            else if($purchase->potongan_pembelian == null){
                $jumlah_potongan_subtotal = array_sum($potongan_subtotal);
            }
        }

        $claim_ongkos_kirim_voucher = null;
        $claim_ongkos_kirim_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'ongkos_kirim')->where('purchase_id', $id)
            ->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')
            ->join('purchases', 'claim_vouchers.checkout_id', '=', 'purchases.checkout_id')
            ->first();

        $total_harga_pembelian = null;
        $total_harga_pembelian = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
            ->where('purchases.purchase_id', $id)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')
            ->first();

        $semua_total_harga_pembelian = null;
        if($purchase->harga_pembelian == null){
            $semua_total_harga_pembelian = $total_harga_pembelian->total_harga_pembelian;
        }

        else if($purchase->harga_pembelian != null){
            $semua_total_harga_pembelian = $purchase->harga_pembelian;
        }

        $courier_name = null;
        if($purchase->courier_code == "pos"){ $courier_name = "POS Indonesia (POS)"; }
        else if($purchase->courier_code == "jne"){ $courier_name = "Jalur Nugraha Eka (JNE)"; }
        else if($purchase->courier_code == "pengiriman_lokal"){ $courier_name = "Pengiriman Lokal Oleh Toko"; }

        $proof_of_payment = null;
        $proof_of_payment = DB::table('proof_of_payments')->where('purchase_id', $id)
        ->first();

        $ongkir = null;
        $ongkir = $purchase->ongkir;
        $ongkir_get_voucher = null;

        if($claim_ongkos_kirim_voucher){
            $ongkir_get_voucher = $purchase->ongkir - $claim_ongkos_kirim_voucher->potongan;

            if($ongkir_get_voucher < 0 ){
                $ongkir_get_voucher = 0;
            }
        }

        $alamat_pembelian = null;
        $alamat_pembelian = DB::table('user_address')->where('user_address_id', $purchase->alamat_purchase)->first();

        return response()->json([
            "purchase" => $purchase,
            "products"=> $products,
            "claim_pembelian_voucher" => $claim_pembelian_voucher,
            "target_kategori" => $target_kategori,
            "subtotal_harga_produk_terkait_seluruh" => $subtotal_harga_produk_terkait_seluruh,
            "jumlah_potongan_subtotal" => $jumlah_potongan_subtotal,
            "claim_ongkos_kirim_voucher" => $claim_ongkos_kirim_voucher,
            "semua_total_harga_pembelian" => $semua_total_harga_pembelian,
            "proof_of_payment" => $proof_of_payment,
            "courier_name" => $courier_name,
            "ongkir" => $ongkir,
            "ongkir_get_voucher" => $ongkir_get_voucher,
            "alamat_pembelian" => $alamat_pembelian,
        ], 200);
    }

    public function delete_purchase_modal(Request $request, $purchase_id){
        $purchase = null;
        $purchase = DB::table("purchases")->where("purchase_id", $purchase_id)
            ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')
            ->first();
            
        return response()->json([
            "purchase" => $purchase,
        ], 200);
    }

    public function hapus_pembelian($purchase_id) {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1])->first();
            
            if(isset($cek_admin_id)){
                DB::table('purchases')->where('purchase_id', $purchase_id)->update([
                    'is_deleted' => 1,
                ]);
        
                return redirect('./daftar_pembelian');
            }
        }
    }

    public function detail_pembelian($purchase_id) {
        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }

        if(Session::get('toko')){
            $toko = Session::get('toko');

            $cek_purchase = DB::table('purchases')->where('purchase_id', $purchase_id)->where('status_pembelian', 'status2')
            ->join('users', 'purchases.user_id', '=', 'users.id')->first();

            $purchase = DB::table('purchases')->where('purchase_id', $purchase_id)->join('users', 'purchases.user_id', '=', 'users.id')->first();

            $profile = DB::table('profiles')->where('user_id', $purchase->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

            $product_purchases = DB::table('product_purchases')->where('merchant_id', $toko)->where('product_purchases.purchase_id', $purchase_id)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

            $product_specifications = DB::table('product_specifications')
            ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
            ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
            ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

            $total_harga = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga'))
            ->where('product_purchases.purchase_id', $purchase_id)->join('products', 'product_purchases.product_id', '=', 'products.product_id')->first();

            $cek_proof_of_payment = DB::table('proof_of_payments')->where('purchase_id', $purchase_id)->first();

            // $purchases = DB::table('purchases')->where('purchase_id', $purchase_id)->join('users', 'purchases.user_id', '=', 'users.id')->first();

            $purchases = DB::table('purchases')->where('purchase_id', $purchase_id)
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

            $profile = DB::table('profiles')->where('user_id', $purchases->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

            $purchases_address = DB::table('user_address')->where('user_id', $purchases->user_id)->first();

            $merchant_purchase = DB::table('product_purchases')->select('merchant_id')->where('purchase_id', $purchase_id)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('merchant_id')->first();

            $merchant_info = DB::table('merchants')->where('merchant_id', $merchant_purchase->merchant_id)->first();

            $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->count();

            $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->first();

            $cek_user_address = DB::table('purchases')->where('purchases.user_id', $purchases->user_id)->where('purchase_id', $purchase_id)
            ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->count();

            $user_address = DB::table('purchases')->where('purchases.user_id', $purchases->user_id)->where('purchase_id', $purchase_id)
            ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->first();

            if($cek_user_address != 0){
                $courier_code = $purchases->courier_code;
                $service = $purchases->service;

                if($courier_code != "" || $service != ""){
                    if($courier_code == "pos"){ $courier_name = "POS Indonesia (POS)"; }
                    else if($courier_code == "jne"){ $courier_name = "Jalur Nugraha Eka (JNE)"; }
                    else if($courier_code == "pengiriman_lokal"){ $courier_name = "Pengiriman Lokal Oleh Toko"; }

                    $service_name = $service;

                    $ongkir = $purchases->ongkir;
                }

                else{
                    $ongkir = 0;
                    $courier_name = "";
                    $service_name = "";
                }

            }

            else if($cek_user_address == 0){
                $lokasi_pembeli = "";
                $ongkir = 0;
                $courier_name = "";
                $service_name = "";
            }


            return view('user.toko.detail_pembelian')->with('product_purchases', $product_purchases)->with('product_specifications', $product_specifications)
            ->with('purchases', $purchases)->with('cek_proof_of_payment', $cek_proof_of_payment)->with('profile', $profile)->with('total_harga', $total_harga)
            ->with('merchant_info', $merchant_info)->with('cek_merchant_address', $cek_merchant_address)->with('merchant_address', $merchant_address)
            ->with('cek_user_address', $cek_user_address)->with('user_address', $user_address)
            ->with('ongkir', $ongkir)->with('courier_name', $courier_name)->with('service_name', $service_name);
        }


        else{
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->whereIn('is_admin', [1, 2])->first();

            if($cek_admin_id){

            }

            else{
                $profile = DB::table('profiles')->where('user_id', $user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

                $purchases = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
                ->join('users', 'purchases.user_id', '=', 'users.id')
                ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

                if($purchases->harga_pembelian == null){
                    $total_harga_pembelian = DB::table('product_purchases')->select(DB::raw('SUM(price * jumlah_pembelian_produk) as total_harga_pembelian'))
                    ->where('purchases.checkout_id', $purchases->checkout_id)
                    ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
                    ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                    ->join('checkouts', 'purchases.checkout_id', '=', 'checkouts.checkout_id')->first();

                    $semua_total_harga_pembelian = $total_harga_pembelian->total_harga_pembelian;
                }

                else if($purchases->harga_pembelian != null){
                    $semua_total_harga_pembelian = $purchases->harga_pembelian;
                }

                $claim_pembelian_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'pembelian')->where('checkout_id', $purchases->checkout_id)->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->first();

                $claim_ongkos_kirim_voucher = DB::table('claim_vouchers')->where('tipe_voucher', 'ongkos_kirim')->where('checkout_id', $purchases->checkout_id)->join('vouchers', 'claim_vouchers.voucher_id', '=', 'vouchers.voucher_id')->first();

                $purchases_address = DB::table('user_address')->where('user_id', $purchases->user_id)->first();

                $merchant_purchase = DB::table('product_purchases')->select('merchant_id')->where('purchase_id', $purchase_id)
                ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('merchant_id')->first();

                $merchant_info = DB::table('merchants')->where('merchant_id', $merchant_purchase->merchant_id)->first();

                $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->count();

                $merchant_address = DB::table('merchant_address')->where('merchant_id', $merchant_purchase->merchant_id)->first();

                $cek_user_address = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
                ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->count();

                $user_address = DB::table('purchases')->where('purchases.user_id', $user_id)->where('purchase_id', $purchase_id)
                ->join('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')->first();

                if($cek_user_address != 0){

                    $total_berat = DB::table('product_purchases')->select(DB::raw('SUM(heavy) as total_berat'))->where('user_id', $user_id)->where('product_purchases.purchase_id', $purchase_id)
                    ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                    ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->first();

                    $courier_code = $purchases->courier_code;
                    $service = $purchases->service;

                    if($courier_code != "" || $service != ""){
                        if($courier_code == "pos"){ $courier_name = "POS Indonesia (POS)"; }
                        else if($courier_code == "jne"){ $courier_name = "Jalur Nugraha Eka (JNE)"; }
                        else if($courier_code == "pengiriman_lokal"){ $courier_name = "Pengiriman Lokal Oleh Toko"; }

                        $service_name = $service;

                        $ongkir = $purchases->ongkir;
                    }

                    else{
                        $ongkir = 0;
                        $courier_name = "";
                        $service_name = "";
                    }
                }

                else if($cek_user_address == 0){
                    $lokasi_pembeli = "";
                    $ongkir = 0;
                    $courier_name = "";
                    $service_name = "";
                }

                $product_purchases = DB::table('product_purchases')->where('user_id', $user_id)->where('product_purchases.purchase_id', $purchase_id)
                ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
                ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.product_purchase_id', 'desc')->get();

                $product_specifications = DB::table('product_specifications')
                ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
                ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
                ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

                $cek_proof_of_payment = DB::table('proof_of_payments')->where('purchase_id', $purchase_id)->first();

                return view('user.pembelian.detail_pembelian')->with('claim_pembelian_voucher', $claim_pembelian_voucher)
                ->with('claim_ongkos_kirim_voucher', $claim_ongkos_kirim_voucher)->with('merchant_info', $merchant_info)
                ->with('cek_merchant_address', $cek_merchant_address)->with('merchant_address', $merchant_address)
                ->with('cek_user_address', $cek_user_address)->with('user_address', $user_address)
                ->with('product_purchases', $product_purchases)->with('profile', $profile)->with('product_specifications', $product_specifications)
                ->with('purchases', $purchases)->with('semua_total_harga_pembelian', $semua_total_harga_pembelian)
                ->with('cek_proof_of_payment', $cek_proof_of_payment)->with('ongkir', $ongkir)
                ->with('courier_name', $courier_name)->with('service_name', $service_name);
            }
        }
    }

    public function detail_pembelian_jasa($service_id) {
        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }

        if(Session::get('toko')){
            $toko = Session::get('toko');

            $service_booking = DB::table('service_booking')->select('*', 'service_booking.id as id')->where('service_booking.id', $service_id)->where('merchant_id', $toko)
            ->join('users', 'service_booking.user_id', '=', 'users.id')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')->first();

            $profile = DB::table('profiles')->where('user_id', $service_booking->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

            // dd($user_address);

            return view('user.toko.detail_pembelian_jasa')->with('service_booking', $service_booking)
            ->with('profile', $profile);
        }


        else{
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->where('is_admin', 1)->first();

            if($cek_admin_id){

            }

            else{

            $service_booking = DB::table('service_booking')->select('*', 'service_booking.id as id')->where('service_booking.id', $service_id)->where('user_id', $user_id)
            ->join('users', 'service_booking.user_id', '=', 'users.id')
            ->join('services', 'service_booking.service_id', '=', 'services.service_id')->first();

            $profile = DB::table('profiles')->where('user_id', $service_booking->user_id)->join('users', 'profiles.user_id', '=', 'users.id')->first();

            // dd($user_address);

            return view('user.pembelian.detail_pembelian_jasa')->with('service_booking', $service_booking)
            ->with('profile', $profile);

            }
        }
    }

    public function PostBuktiPembayaran(Request $request, $purchase_id) {
        $proof_of_payment_image = $request -> file('proof_of_payment_image');

        $proof_of_payment_image_name = time().'_'.$proof_of_payment_image->getClientOriginalName();
        $tujuan_upload = './asset/u_file/proof_of_payment_image';
        $proof_of_payment_image->move($tujuan_upload,$proof_of_payment_image_name);

        DB::table('proof_of_payments')->insert([
            'purchase_id' => $purchase_id,
            'proof_of_payment_image' => $proof_of_payment_image_name,
        ]);


        return redirect()->back();
    }

    public function PostBuktiPembayaranJasa(Request $request, $id) {
        $proof_of_payment_image = $request -> file('proof_of_payment_image');

        $proof_of_payment_image_name = time().'_'.$proof_of_payment_image->getClientOriginalName();
        $tujuan_upload = './asset/u_file/proof_of_payment_image';
        $proof_of_payment_image->move($tujuan_upload,$proof_of_payment_image_name);

        $kode_pembelian = 'rkt_'.time();

        $service_booking = DB::table('service_booking')->where('service_booking.id', $id)
        ->join('services', 'service_booking.service_id', '=', 'services.service_id')->first();

        DB::table('proof_of_service_payments')->insert([
            'service_booking_id' => $id,
            'proof_of_payment_image' => $proof_of_payment_image_name,
        ]);

        DB::table('service_purchases')->insert([
            'service_booking_id' => $id,
            'amount' => $service_booking->price,
            'price' => $service_booking->price,
            'start_date' => $service_booking->start_date,
            'end_date' => $service_booking->end_date,
            'notes' => $service_booking->notes,
            'status' => 'on progress',
            'purchase_code' => $kode_pembelian
        ]);


        return redirect('../daftar_pembelian');
    }

    public function batalkan_pembelian(Request $request, $purchase_id) {

        DB::table('purchases')->where('purchase_id', $purchase_id)->update([
            'is_cancelled' => 1,
        ]);

        return redirect()->back();
    }

    public function update_status_pembelian(Request $request, $purchase_id)
    {
        date_default_timezone_set('Asia/Jakarta');
    
        $purchase = DB::table('purchases')->where('purchase_id', $purchase_id)->first();
        if (!$purchase) {
            return redirect()->back()->with('error', 'Pembelian tidak ditemukan.');
        }
    
        $new_status = null;
    
        if ($purchase->status_pembelian == "status1") {
            $new_status = "status2";
        } elseif ($purchase->status_pembelian == "status3") {
            $new_status = "status4";
        } elseif ($purchase->status_pembelian == "status4") {
            $new_status = "status5";
        } elseif ($purchase->status_pembelian == "status1_ambil") {
            $new_status = "status2_ambil";
        } elseif ($purchase->status_pembelian == "status2_ambil") {
            $new_status = "status4_ambil_a"; // langsung loncat
        } elseif ($purchase->status_pembelian == "status3_ambil") {
            $new_status = "status4_ambil_a";
        } elseif ($purchase->status_pembelian == "status4_ambil_a") {
            $new_status = "status4_ambil_b";
        } elseif ($purchase->status_pembelian == "status4_ambil_b") {
            $new_status = "status5_ambil";
        }
    
        if ($new_status) {
            DB::table('purchases')->where('purchase_id', $purchase_id)->update([
                'status_pembelian' => $new_status,
                'updated_at' => Carbon::now(),
            ]);
    
            // Jika status menjadi status2 atau status2_ambil, buat notifikasi
            if ($new_status == "status2" || $new_status == "status2_ambil") {
                $product_purchase = DB::table('product_purchases')
                    ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
                    ->select('products.merchant_id', 'products.product_name')
                    ->where('product_purchases.purchase_id', $purchase_id)
                    ->first();
    
                if ($product_purchase) {
                    $merchant_user = DB::table('merchants')
                        ->select('user_id')
                        ->where('merchant_id', $product_purchase->merchant_id)
                        ->first();
    
                    if ($merchant_user) {
                        $merchantUserModel = User::find($merchant_user->user_id);
                        if ($merchantUserModel) {
                            $merchantUserModel->notify(new ProductPurchasedNotification($purchase_id, $product_purchase->product_name));
                        }
                    }
                }
            }
        }
    
        return redirect()->back()->with('success', 'Status pembelian diperbarui.');
    }    

    public function update_status2_pembelian(Request $request, $purchase_id) {
        date_default_timezone_set('Asia/Jakarta');

        $purchases = DB::table('purchases')->where('purchase_id', $purchase_id)->first();

        if($purchases->status_pembelian == "status2"){
            $no_resi = $request->no_resi;

            if($no_resi){
                DB::table('purchases')->where('purchase_id', $purchase_id)->update([
                    'no_resi' => $no_resi,
                    'status_pembelian' => 'status3',
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return redirect()->back();
    }

    public function update_no_resi(Request $request, $purchase_id) {
        date_default_timezone_set('Asia/Jakarta');

        $no_resi = $request->no_resi;

        DB::table('purchases')->where('purchase_id', $purchase_id)->update([
            'no_resi' => $no_resi,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->back();
    }

    public function setuju_jasa($service_booking_id){
        DB::table('service_booking')->where('id', $service_booking_id)->update([
            'status' => 'approved',
            'updated_at' => Carbon::now(),
        ]);

        return redirect('../daftar_pembelian');
    }

    public function tolak_jasa($service_booking_id){
        DB::table('service_booking')->where('id', $service_booking_id)->update([
            'status' => 'declined',
            'updated_at' => Carbon::now(),
        ]);

        return redirect('../daftar_pembelian');
    }

    public function terima_pembayaran_jasa($service_purchase_id, $service_booking_id){

        DB::table('service_purchases')->where('service_purchase_id', $service_purchase_id)->update([
            'status' => 'paid'
        ]);

        DB::table('service_booking')->where('id', $service_booking_id)->update([
            'status' => 'on progress',
            'updated_at' => Carbon::now(),
        ]);

        return redirect('../daftar_pembelian#custom-tabs-three-profile');
    }

    public function tolak_pembayaran_jasa($service_purchase_id){

        DB::table('service_purchases')->where('service_purchase_id', $service_purchase_id)->update([
            'status' => 'unpaid'
        ]);

        return redirect('../daftar_pembelian');
    }

    public function konfirmasi_pesanan_selesai($service_booking_id){

        DB::table('service_booking')->where('id', $service_booking_id)->update([
            'status' => 'done',
            'updated_at' => Carbon::now(),
        ]);

        return redirect('../daftar_pembelian');
    }

    public function daftar_pemesan(Request $request){
        $tikets = PemesananTiket::all();

        return view('admin.daftar_pemesanan')->with('tikets', $tikets);
    }

    public function daftar_pemesanan_rental(Request $request){

        $rentals = PemesananRental::all();

        return view('admin.daftar_pemesanan_rental')->with('rentals', $rentals);
    }


    /**
     * Untuk memilih waktu rentang total pembelian pada Home Admin
     */

    public function jumlah_pembelian(Request $request) {
        $tanggal_awal_pembelian = $_GET['tanggal_awal_pembelian'];
        $tanggal_akhir_pembelian = $_GET['tanggal_akhir_pembelian'];

        $jumlah_pembelian = DB::table('purchases')->where('is_cancelled', 0)->where('is_deleted', 0)
        ->whereBetween('updated_at', [$tanggal_awal_pembelian, $tanggal_akhir_pembelian])
        ->where(function($query) {
            $query->where('status_pembelian', "status4")
                ->orWhere('status_pembelian', "status4_ambil_b")
                ->orWhere('status_pembelian', "status5")
                ->orWhere('status_pembelian', "status5_ambil")
                ->orWhere('status_pembelian', "status3_ambil")
                ->orWhere('status_pembelian', "status3")
                ->orWhere('status_pembelian', "status2_ambil")
                ->orWhere('status_pembelian', "status2");
        })->count();

        return response()->json(compact(['tanggal_awal_pembelian', 'tanggal_akhir_pembelian', 'jumlah_pembelian']));
    }


    /**
     * Route khusus untu kebutuhan khusus untuk hapus data dummy testing
     */

    public function delete_dummy_testing(Request $request)
    {
        $purchases = DB::table('purchases')->where('user_id', 699)->get();

        foreach ($purchases as $purchase) {
            DB::table('product_purchases')->where('purchase_id', $purchase->purchase_id)->delete();
        }
        DB::table('purchases')->where('user_id', 699)->delete();
        DB::table('checkouts')->where('user_id', 699)->delete();
    }
}

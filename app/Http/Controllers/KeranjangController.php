<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class KeranjangController extends Controller
{
    /**
     * Menampilkan daftar produk yang telah ditambakan ke dalam keranjang.
     */

    public function keranjang() {

        // set logout saat habis session dan auth

        if(!Auth::check()){
            return redirect("./logout");
        }
        
        $user_id = Auth::user()->id;
        $merchants = DB::table('merchants')->get();
        
        $cart_by_merchants = DB::table('carts')->select('merchant_id')->where('user_id', $user_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->groupBy('merchant_id')->get();
        $service_cart_by_merchants = DB::table('service_carts')->select('merchant_id')->where('user_id', $user_id)
        ->join('services', 'service_carts.service_id', '=', 'services.service_id')->groupBy('merchant_id')->get();

        $carts = DB::table('carts')->where('user_id', $user_id)->join('products', 'carts.product_id', '=', 'products.product_id')->get();
        $service_carts = DB::table('service_carts')->where('user_id', $user_id)->join('services', 'service_carts.service_id', '=', 'services.service_id')->get();

        $cek_carts = DB::table('carts')->where('user_id', $user_id)->first();
        $cek_service_carts = DB::table('service_carts')->where('user_id', $user_id)->first();
        
        $stocks = DB::table('stocks')->get();

        return view('user.pembelian.keranjang')->with('merchants', $merchants)->with('cart_by_merchants', $cart_by_merchants)
        ->with('carts', $carts)->with('cek_carts', $cek_carts)->with('cek_service_carts', $cek_service_carts)->with('stocks', $stocks)->with('service_carts', $service_carts)->with('service_cart_by_merchants', $service_cart_by_merchants);
    }

    
    /**
     * Menambahkan produk ke dalam keranjang ke dakam tabel " carts ".
     * Melalui AJAX yang terdapat pada file function_2.js untuk " #tambah_produk_keranjang ".
     */

    public function masuk_keranjang(Request $request) {
        $user_id = Auth::user()->id;
        $produk = $_GET['produk'];
                
        $jumlah_masuk_keranjang = DB::table('carts')->select('jumlah_masuk_keranjang')->where('user_id', $user_id)->where('product_id', $produk)->first();

        $cek_keranjang = DB::table('carts')->where('user_id', $user_id)->where('product_id', $produk)->first();
        
        if($cek_keranjang){
            DB::table('carts')->where('user_id', $user_id)->where('product_id', $produk)->update([
                'jumlah_masuk_keranjang' => $jumlah_masuk_keranjang->jumlah_masuk_keranjang + 1,
            ]);
        }
        
        else{
            DB::table('carts')->insert([
                'user_id' => $user_id,
                'product_id' => $produk,
                'jumlah_masuk_keranjang' => 1,
            ]);
        }

        $jumlah_produk_keranjang = DB::table('carts')->where('user_id', $user_id)->count();

        return response()->json($jumlah_produk_keranjang);
    }


    /**
     * Menambahkan produk ke dalam keranjang ke dakam tabel " carts ".
     * Dengan memasukkan jumlah inputan dengan keprluan untuk dapat membeli produk secara langsung.
     * Langsung menuju keranjang agar produk dapat dilanjutkan pada prosess checkout
     */

    public function masuk_keranjang_beli(Request $request, $product_id) {
        $user_id = Auth::user()->id;
        
        $jumlah_pembelian_produk = $request -> jumlah_pembelian_produk;

        $cek_keranjang = DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_id)->first();
        
        $jumlah_masuk_keranjang = DB::table('carts')->select('jumlah_masuk_keranjang')->where('user_id', $user_id)->where('product_id', $product_id)->first();

        if($cek_keranjang){
            DB::table('carts')->where('user_id', $user_id)->where('product_id', $product_id)->update([
                'jumlah_masuk_keranjang' => $jumlah_masuk_keranjang->jumlah_masuk_keranjang + $jumlah_pembelian_produk,
            ]);
        }
        
        else{
            DB::table('carts')->insert([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'jumlah_masuk_keranjang' => $jumlah_pembelian_produk,
            ]);
        }

        return redirect('keranjang');
    }

    public function masuk_keranjang_beli_jasa(Request $request, $service_id) {
        $user_id = Auth::user()->id;

        $cek_keranjang = DB::table('service_carts')->where('user_id', $user_id)->where('service_id', $service_id)->first();
        
        DB::table('service_carts')->insert([
            'user_id' => $user_id,
            'service_id' => $service_id
        ]);

        return redirect('keranjang');
    }

    public function HapusKeranjang($cart_id)
    {
        DB::table('carts')->where('cart_id', $cart_id)->delete();
        DB::table('service_carts')->where('cart_id', $cart_id)->delete();
        
        return redirect('./keranjang');
    }
}

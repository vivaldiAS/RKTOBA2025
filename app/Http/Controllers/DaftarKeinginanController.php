<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class DaftarKeinginanController extends Controller
{
    /**
     * Menampilkan daftar produk yang telah ditambakan ke dalam daftar keinginan.
     */

    public function daftar_keinginan(Request $request) {

        // set logout saat habis session dan auth
        
        if(!Auth::check()){
            return redirect("./logout");
        }
        
        $user_id = Auth::user()->id;

        $cek_wishlists = DB::table('wishlists')->where('user_id', $user_id)->first();

        $wishlists = DB::table('wishlists')->select('wishlist_id','wishlists.product_id', 'product_name', 'type', 'price', 'products.merchant_id', 'nama_merchant')->where('wishlists.user_id', $user_id)
        ->join('products', 'wishlists.product_id', '=', 'products.product_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->groupBy('wishlist_id', 'wishlists.product_id', 'product_name', 'type', 'price', 'products.merchant_id', 'nama_merchant')->get();
       
        $stocks = DB::table('stocks')->get();

        return view('user.pembelian.daftar_keinginan')->with('cek_wishlists', $cek_wishlists)->with('wishlists', $wishlists)
        ->with('stocks', $stocks);
    }


    /**
     * Menambahkan produk sebagai produk yang diinginkan  ke dakam tabel " wishlists ".
     * Melalui AJAX yang terdapat pada file function_2.js untuk " #tambah_produk_keinginan ".
     */

    public function masuk_daftar_keinginan(Request $request) {
        $user_id = Auth::user()->id;
        $produk = $_GET['produk'];
        
        DB::table('wishlists')->insert([
            'user_id' => $user_id,
            'product_id' => $produk,
        ]);

        $jumlah_produk_keinginan = DB::table('wishlists')->where('user_id', $user_id)->count();

        return response()->json(compact(['jumlah_produk_keinginan', 'produk']));
    }


    /**
     * Menghapus produk dari daftar keinginan pada tabel " wishlists ".
     * Melalui AJAX yang terdapat pada file function_2.js untuk " #hapus_produk_keinginan ".
     */

    public function hapus_daftar_keinginan(Request $request) {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $produk = $_GET['produk'];
            
            DB::table('wishlists')->where('product_id', $produk)->where('user_id', $user_id)->delete();

            $jumlah_produk_keinginan = DB::table('wishlists')->where('user_id', $user_id)->count();

            return response()->json(compact(['jumlah_produk_keinginan', 'produk']));
        }
    }

    
    /**
     * Menghapus daftar keinginan pada tabel " wishlists ".
     */
    
    public function hapus_produk_pada_daftar_keinginan($wishlist_id) {
        if(Auth::check()){
            DB::table('wishlists')->where('wishlist_id', $wishlist_id)->delete();

            return redirect('./daftar_keinginan');
        }
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    public function keranjang(Request $request)
    {
        $carts = DB::table('carts')
            ->where('carts.user_id', $request->user_id)
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->join('merchants', 'merchants.merchant_id', '=', 'products.merchant_id')
            ->join('merchant_address', 'merchants.merchant_id', '=', 'merchant_address.merchant_id')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->orderBy('carts.created_at', 'desc')
            ->get();
        $cart_by_merchants = DB::table('carts')->select('merchant_id')->where('user_id', $request->user_id)
        ->join('products', 'carts.product_id', '=', 'products.product_id')->groupBy('merchant_id')->get();

        return response()->json([
            'cart' => $carts,
            'cart_by_merchants' => $cart_by_merchants,
        ]);
    }

    public function masuk_keranjang(Request $request)
    {
        $cekpesanan = DB::table('carts')
            ->select('product_id')
            ->where('user_id', '=', $request->user_id)
            ->where('product_id', '=', $request->product_id)
            ->get();

        if (empty(json_decode($cekpesanan))) {
            DB::table('carts')->insert([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'jumlah_masuk_keranjang' => $request->jumlah_masuk_keranjang,
            ]);
        } else {
            DB::table('carts')
                ->where('product_id', '=', $request->product_id)
                ->update(['jumlah_masuk_keranjang' => DB::raw('jumlah_masuk_keranjang + ' . $request->jumlah_masuk_keranjang)]);
        }
        DB::table('stocks')
            ->where('product_id', '=', $request->product_id)
            ->update(['stok' => DB::raw('stok - ' . $request->jumlah_masuk_keranjang)]);

        $jumlah_produk_keranjang = DB::table('carts')->where('user_id', $request->user_id)->count();

        return response()->json(
            $jumlah_produk_keranjang,
            200
        );
    }

    public function hapus(Request $request)
    {
        $jumlah_masuk_keranjang = DB::table('carts')
            ->select('jumlah_masuk_keranjang')
            ->where('cart_id', '=', $request->cart_id)
            ->value('jumlah_masuk_keranjang');

        DB::table('stocks')
            ->select('carts.product_id', 'stocks.stok')
            ->join('carts', 'carts.product_id', '=', 'stocks.product_id')
            ->where('carts.cart_id', '=', $request->cart_id)
            ->update(['stocks.stok' => DB::raw('stocks.stok + ' . $jumlah_masuk_keranjang)]);

        if (DB::table('carts')
            ->where('cart_id', '=', $request->cart_id)->delete()
        ) {

            return response()->json(
                200
            );
        }
    }

    public function kurang(Request $request)
    {
        $jumlah_masuk_keranjang = DB::table('carts')
            ->select('jumlah_masuk_keranjang')
            ->where('cart_id', '=', $request->cart_id)
            ->value('jumlah_masuk_keranjang');

        if ($jumlah_masuk_keranjang == 1) {
            DB::table('carts')
                ->where('cart_id', '=', $request->cart_id)->delete();
        } else {
            DB::table('carts')
                ->where('cart_id', '=', $request->cart_id)
                ->update(['jumlah_masuk_keranjang' => DB::raw('jumlah_masuk_keranjang - 1')]);
        }
        $update = DB::table('stocks')
            ->select('carts.product_id', 'stocks.stok')
            ->join('carts', 'carts.product_id', '=', 'stocks.product_id')
            ->where('carts.cart_id', '=', $request->cart_id)
            ->update(['stocks.stok' => DB::raw('stocks.stok + 1')]);

        if ($update) {
            return response()->json(
                200
            );
        }
    }

    public function tambah(Request $request)
    {
        $update = DB::table('stocks')
            ->select('stocks.stok')
            ->join('carts', 'carts.product_id', '=', 'stocks.product_id')
            ->where('carts.cart_id', '=', $request->cart_id)
            ->value('stocks.stok');


        if ($update == 0) {
            return response()->json(
                1
            );
        } else {
            DB::table('carts')
                ->where('cart_id', '=', $request->cart_id)
                ->update(['jumlah_masuk_keranjang' => DB::raw('jumlah_masuk_keranjang + 1')]);

            $update = DB::table('stocks')
                ->select('carts.product_id', 'stocks.stok')
                ->join('carts', 'carts.product_id', '=', 'stocks.product_id')
                ->where('carts.cart_id', '=', $request->cart_id)
                ->update(['stocks.stok' => DB::raw('stocks.stok - 1')]);

            if ($update) {
                return response()->json(
                    200
                );
            }
        }
    }
}

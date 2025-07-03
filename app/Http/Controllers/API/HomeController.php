<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    //
    public function dashboard(Request $request)
    {
        $merchant_id = DB::table('merchants')
        ->where('user_id', $request->user_id)
        ->pluck('merchant_id');

        $count_status = DB::table('product_purchases')
            ->select('purchases.purchase_id')
            ->where('merchant_id', $merchant_id)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->groupBy('purchases.purchase_id')
            ->get();


        $count_status = DB::table('product_purchases')
            ->select('purchases.purchase_id')
            ->where('merchant_id', $merchant_id)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->groupBy('purchases.purchase_id')
            ->get();


        $count_status = DB::table('product_purchases')
            ->select('purchases.purchase_id')
            ->where('merchant_id', $merchant_id)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->groupBy('purchases.purchase_id')
            ->get();

        $jumlah_pesanan_sedang_berlangsung = 0;
        $jumlah_pesanan_berhasil_belum_dibayar = 0;
        $jumlah_pesanan_berhasil_telah_dibayar = 0;

        foreach ($count_status as $count) {
            $jumlah_pesanan_sedang_berlangsung += DB::table('purchases')->where('purchase_id', $count->purchase_id)->whereIn('status_pembelian', ['status2', 'status2_ambil', 'status3', 'status3_ambil', 'status4_ambil_a'])->count();
            $jumlah_pesanan_berhasil_belum_dibayar += DB::table('purchases')->where('purchase_id', $count->purchase_id)->whereIn('status_pembelian', ['status4', 'status4_ambil_b'])->count();
            $jumlah_pesanan_berhasil_telah_dibayar += DB::table('purchases')->where('purchase_id', $count->purchase_id)->whereIn('status_pembelian', ['status5', 'status5_ambil'])->count();
        }


        $jumlah_produk = DB::table('products')
        ->join('merchants', 'merchants.merchant_id', '=', 'products.merchant_id')
        ->where('products.is_deleted', 0)
        ->where('user_id', $request->user_id)
        ->count();


        return response()->json([
            'jumlah_pesanan_sedang_berlangsung' => $jumlah_pesanan_sedang_berlangsung,
            'jumlah_pesanan_berhasil_belum_dibayar' => $jumlah_pesanan_berhasil_belum_dibayar,
            'jumlah_pesanan_berhasil_telah_dibayar' => $jumlah_pesanan_berhasil_telah_dibayar,
            'jumlah_produk' => $jumlah_produk
        ]);

    }

}

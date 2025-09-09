<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WishlistController extends Controller
{
    //
    public function tambahWishlist(Request $request)
    {
        $cekwishlist = DB::table('wishlists')
            ->select('product_id')
            ->where('user_id', '=', $request->user_id)
            ->where('product_id', '=', $request->product_id)
            ->get();

        if (empty(json_decode($cekwishlist))) {
            DB::table('wishlists')->insert([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
            ]);
            return response()->json([
                'message' => 'Produk berhasil ditambahkan',
            ]);
        } else {
            return response()->json([
                'message' => 'Produk sudah ditambahkan sebelumnya',
            ]);
        }
    }

public function daftarWishlist(Request $request)
{
    $wishlist = DB::table('wishlists')
        ->where('wishlists.user_id', '=', $request->user_id)
        ->join('products', 'wishlists.product_id', '=', 'products.product_id')
        ->join('merchants', 'merchants.merchant_id', '=', 'products.merchant_id')
        ->leftJoin(DB::raw('(SELECT product_id, MIN(product_image_name) as product_image_name FROM product_images GROUP BY product_id) as pi'), 'pi.product_id', '=', 'products.product_id')
        ->leftJoin(DB::raw('(SELECT product_id, SUM(jumlah_pembelian_produk) as count_product_purchases FROM product_purchases GROUP BY product_id) as pp'), 'pp.product_id', '=', 'products.product_id')
        ->leftJoin(DB::raw('(SELECT product_id, ROUND(AVG(nilai_review),1) as average_rating FROM reviews GROUP BY product_id) as r'), 'r.product_id', '=', 'products.product_id')
        ->select(
            'wishlists.*',
            'products.product_name',
            'products.product_description',
            'products.price',
            'products.heavy',
            'merchants.nama_merchant',
            'products.merchant_id',
            'products.category_id',
            'products.is_deleted',
            'pi.product_image_name',
            DB::raw('COALESCE(pp.count_product_purchases,0) as count_product_purchases'),
            DB::raw('COALESCE(r.average_rating,0) as average_rating')
        )
        ->get();

    return response()->json($wishlist);
}



    public function hapusWishlist(Request $request)
    {

        if (DB::table('wishlists')
            ->where('wishlist_id', '=', $request->wishlist_id)->delete()
        ) {
            return response()->json(
                200
            );
        }
    }
}

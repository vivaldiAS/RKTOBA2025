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
            ->get();

        return response()->json(
            $wishlist,
        );
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

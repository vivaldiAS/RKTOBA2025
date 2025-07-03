<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    // Ambil semua review
    public function index()
    {
        $reviews = DB::table('reviews')->get();
        return response()->json($reviews);
    }

    // Ambil semua review berdasarkan product_id
    public function show($product_id)
    {
        $reviews = DB::table('reviews')
                    ->where('product_id', $product_id)
                    ->get();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found for this product'], 404);
        }

        return response()->json($reviews);
    }

    public function store(Request $request)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'product_id' => 'required|integer',
        'nilai_review' => 'required|integer|min:1|max:5',
        'isi_review' => 'required|string',
    ]);

    $user_id = Auth::user()->id;

    $review_id = DB::table('reviews')->insertGetId([
        'user_id' => $user_id,
        'product_id' => $request->product_id,
        'nilai_review' => $request->nilai_review,
        'isi_review' => $request->isi_review,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'message' => 'Review berhasil ditambahkan',
        'review_id' => $review_id,
    ], 201);
}

public function averageRating($productId)
{
    $average = DB::table('reviews')
        ->where('product_id', $productId)
        ->avg('nilai_review');

    return response()->json([
        'product_id' => $productId,
        'average_rating' => round($average ?? 0, 1) // dibulatkan ke 1 angka desimal
    ]);
}


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class TinjauanController extends Controller
{
    /**
     * Memproses pemberian tinjauan oleh pengguna pada produk dengan penambahan tinjauan ke dalam tabel " reviews ".
     */

    public function PostTinjauan(Request $request, $product_id) {
        $user_id = Auth::user()->id;

        $nilai_review = $request -> nilai_review;
        $isi_review = $request -> isi_review;

        DB::table('reviews')->insert([
            'user_id' => $user_id,
            'product_id' =>  $product_id,
            'nilai_review' => $nilai_review,
            'isi_review' =>  $isi_review,
        ]);
        
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    public function profilDenganToken(Request $request) {
    // Ambil user dari token (middleware auth sudah verify)
    $user = $request->user();

    $toko = DB::table('merchants')
        ->where('user_id', $user->id)
        ->first();

    return response()->json($toko);
}

    public function index(Request $request){
        $toko = DB::table('merchants')
        ->where('user_id', $request->user_id)
        ->first();

        return response()->json(
            $toko
        );
    }
    public function daftartenant()
    {
        $banks = DB::table('merchants')->orderBy('nama_merchant', 'asc')->get();
        return response()->json(
            $banks
        );
    }
}
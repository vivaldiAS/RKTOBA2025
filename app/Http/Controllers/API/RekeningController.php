<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class RekeningController extends Controller
{
    //

    public function daftarbank()
    {
        $banks = DB::table('banks')->orderBy('nama_bank', 'asc')->get();
        return response()->json(
            $banks
        );
    }
    
    public function daftar_rekening(Request $request)
    {
        $rekenings = DB::table('rekenings')->where('user_id', $request->user_id)->orderBy('rekening_id', 'asc')->get();
        return response()->json(
            $rekenings
        );
    }

    public function HapusRekening(Request $request)
    {

        if (DB::table('rekenings')->where('rekening_id', $request->rekening_id)->delete()) {
            return response()->json(
                200
            );
        }
    }
}

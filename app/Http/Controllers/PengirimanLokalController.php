<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class PengirimanLokalController extends Controller
{
    /**
     * Menampilkan halaman form untuk menambahkan pengiriman lokal.
     */

    public function pengiriman_lokal(Request $request) {
        $toko = Session::get('toko');

        $merchant_address = DB::table('merchant_address')->where('merchant_id', $toko)->first();

        return view('user.toko.pengiriman_lokal')->with('merchant_address', $merchant_address);
    }


    /**
     * Menyimpan penambahan pengiriman lokal ke dalam tabel " shipping_locals ".
     */

    public function PostPengirimanLokal(Request $request) {
        $subdistrict_id = $request -> subdistrict;
        $biaya_jasa = $request -> biaya_jasa;

        $toko = Session::get('toko');
        
        $merchant_address = DB::table('merchant_address')->where('merchant_id', $toko)->first();

        DB::table('shipping_locals')->insert([
            'merchant_id' => $toko,
            'shipping_local_province_id' => $merchant_address->province_id,
            'shipping_local_city_id' => $merchant_address->city_id,
            'shipping_local_subdistrict_id' => $subdistrict_id,
            'biaya_jasa' => $biaya_jasa,
        ]);

        return redirect('./daftar_pengiriman_lokal');
    }


    /**
     * Menampilkan halaman daftar pengiriman yang telah ditambahkan.
     */

    public function daftar_pengiriman_lokal() {
        // set logout saat habis session dan auth
        if(!Auth::check()){
            return redirect("./logout");
        }
        
        if(Session::get('toko')){
            
            $toko = Session::get('toko');

            $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $toko)->count();

            if($cek_merchant_address == 0){
                return redirect('./alamat');
            }
            
            else if($cek_merchant_address > 0){
                $shipping_locals = DB::table('shipping_locals')->where('merchant_id', $toko)->get();
    
                $cek_shipping_locals = DB::table('shipping_locals')->where('merchant_id', $toko)->count();
    
                if($cek_shipping_locals == 0){
                    return redirect('./pengiriman_lokal');
                }
    
                else{
                    return view('user.toko.daftar_pengiriman_lokal')->with('shipping_locals', $shipping_locals);
                }
            }
        }
    }


    /**
     * Menghapus pengiriman lokal dari tabel " shipping_locals ".
     */

    public function HapusPengirimanLokal($shipping_local_id)
    {
        if(Auth::check()){
            if(Session::get('toko')){
                $toko = Session::get('toko');
                
                DB::table('shipping_locals')->where('shipping_local_id', $shipping_local_id)->delete();
                    
                return redirect('./daftar_pengiriman_lokal');
            }
        }
    }

}

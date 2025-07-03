<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class RekeningController extends Controller
{
    /**
     * Menampilkan halaman form untuk menambahkan rekening.
     */

    public function rekening() {
        $banks = DB::table('banks')->orderBy('nama_bank', 'asc')->get();

        return view('user.rekening')->with('banks', $banks);
    }


    /**
     * Menyimpan penambahan rekening ke dalam tabel " rekenings ".
     */

    public function PostRekening(Request $request) {
        $id = Auth::user()->id;
        $nama_bank = $request -> nama_bank;
        $nomor_rekening = $request -> nomor_rekening;
        $atas_nama = $request -> atas_nama;

        DB::table('rekenings')->insert([
            'user_id' => $id,
            'nama_bank' => $nama_bank,
            'nomor_rekening' => $nomor_rekening,
            'atas_nama' => $atas_nama,
        ]);

        if(Auth::check()){
            if(Session::get('toko')){
                return redirect('./daftar_rekening');
            }
            else{
                return redirect('./toko');
            }
        }
    }


    /**
     * Menampilkan halaman daftar alamat yang telah ditambahkan.
     */

    public function daftar_rekening() {
        $is_admin = Auth::user()->is_admin;

        
        // Menampilkan daftar seluruh rekening toko pada Admin.

        if($is_admin == 1 || $is_admin == 2){
            $merchants = DB::table('merchants')->join('users', 'merchants.user_id', '=', 'users.id')
            ->join('profiles', 'merchants.user_id', '=', 'profiles.user_id')->orderBy('merchant_id', 'desc')->get();
            $rekenings = DB::table('rekenings')->join('users', 'rekenings.user_id', '=', 'users.id')->orderBy('rekenings.user_id', 'desc')->orderBy('rekening_id', 'asc')->get();
            $profiles = DB::table('profiles')->orderBy('profile_id', 'asc')->get();

            return view('admin.daftar_rekening')->with('merchants', $merchants)->with('rekenings', $rekenings)->with('profiles', $profiles);
        }


        // Menampilkan daftar seluruh rekening yang toko miliki.

        else{
            if(Session::get('toko')){
                $user_id = Auth::user()->id;
                $rekenings = DB::table('rekenings')->where('user_id', $user_id)->orderBy('rekening_id', 'asc')->get();
    
                return view('user.toko.daftar_rekening')->with('rekenings', $rekenings);
            }
        }   
    }


    /**
     * Menghapus rekening dari tabel " rekenings ".
     */

    public function HapusRekening($rekening_id)
    {
        if(Auth::check()){
            if(Session::get('toko')){
                $toko = Session::get('toko');

                DB::table('rekenings')->where('rekening_id', $rekening_id)->delete();
                
                return redirect('./daftar_rekening');
            }
        }
    }
}

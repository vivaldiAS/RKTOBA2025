<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class BankController extends Controller
{
    /**
     * Menampilkan daftar bank yang ditambahkan.
     */

    public function bank() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                $banks = DB::table('banks')->orderBy('nama_bank', 'asc')->get();

                return view('admin.bank')->with('banks', $banks)->with('cek_admin_id', $cek_admin_id);
            }
        }
    }


    /**
     * Menambahkan data bank yang disediakan untuk rekening bank ke dalam tabel " banks ".
     */

    public function PostTambahBank(Request $request) {
        $nama_bank = $request -> nama_bank;

        DB::table('banks')->insert([
            'nama_bank' => $nama_bank,
        ]);

        return redirect('./bank');
    }

    
    /**
     * Memperbarui data bank yang tersedia.
     */

    public function PostEditBank(Request $request, $bank_id) {
        $nama_bank = $request -> nama_bank;

        DB::table('banks')->where('id', $bank_id)->update([
            'nama_bank' => $nama_bank,
        ]);

        return redirect('./bank');
    }


    /**
     * Menghapus data bank pada tabel " banks ".
     */

    public function HapusBank($bank_id)
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                DB::table('banks')->where('id', $bank_id)->delete();
                
                return redirect('./bank');
            }
        }
    }
}

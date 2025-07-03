<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class VoucherController extends Controller
{
    /**
     * Menampilkan daftar voucher yang ditambahkan.
     */

    public function voucher() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                date_default_timezone_set('Asia/Jakarta');
                
                $vouchers = DB::table('vouchers')->where('is_deleted', 0)->orderBy('nama_voucher', 'desc')->get();
                
                $categories = DB::table('categories')->orderBy('nama_kategori', 'asc')->get();

                return view('admin.voucher')->with('vouchers', $vouchers)->with('categories', $categories)
                ->with('cek_admin_id', $cek_admin_id);
            }
        }
    }


    /**
     * Memilih tipe voucher dan menjalankan AJAX yang terdapat pada file function_2.js untuk " #tipe_voucher ".
     */

    public function pilih_tipe_voucher() {
        $tipe_voucher = $_GET['tipe'];
        
        return response()->json($tipe_voucher);
    }

    
    /**
     * Menambahkan voucher ke dalam tabel " vouchers " agar dapat dipakai oleh pembeli.
     */

    public function PostTambahVoucher(Request $request) {
        $nama_voucher = $request -> nama_voucher;
        $tipe_voucher = $request -> tipe_voucher;
        $potongan = $request -> potongan;
        $minimal_pengambilan = $request -> minimal_pengambilan;
        $maksimal_pemotongan = $request -> maksimal_pemotongan;
        $tanggal_berlaku = $request -> tanggal_berlaku;
        $tanggal_batas_berlaku = $request -> tanggal_batas_berlaku;


        // Jika kondisi terpenuhi yaitu tipe voucher yang ditambahkan adalah pembelian.
        
        if($tipe_voucher == "pembelian"){
            $target_kategori = $request -> target_kategori;
            $target_metode_pembelian = $request -> target_metode_pembelian;
            
            $request -> validate([
                'nama_voucher' => 'required',
                'tipe_voucher' => 'required',
                'target_kategori' => 'required',
                'potongan' => 'required|integer',
                'minimal_pengambilan' => 'required|integer',
                'maksimal_pemotongan' => 'required|integer',
                'tanggal_berlaku' => 'required',
                'tanggal_batas_berlaku' => 'required',
            ]);

            DB::table('vouchers')->insert([
                'nama_voucher' => $nama_voucher,
                'tipe_voucher' => $tipe_voucher,
                'target_kategori' => implode(", ", $target_kategori),
                'target_metode_pembelian' => $target_metode_pembelian,
                'potongan' => $potongan,
                'minimal_pengambilan' => $minimal_pengambilan,
                'maksimal_pemotongan' => $maksimal_pemotongan,
                'tanggal_berlaku' => $tanggal_berlaku,
                'tanggal_batas_berlaku' => $tanggal_batas_berlaku,
                'is_deleted' => 0,
            ]);
        }
        

        // Jika kondisi terpenuhi yaitu tipe voucher yang ditambahkan adalah ongkos kirim.

        else if($tipe_voucher == "ongkos_kirim"){
            $target_metode_pembelian = $request -> target_metode_pembelian;

            $request -> validate([
                'nama_voucher' => 'required',
                'tipe_voucher' => 'required',
                'potongan' => 'required|integer',
                'minimal_pengambilan' => 'required|integer',
                'tanggal_berlaku' => 'required',
                'tanggal_batas_berlaku' => 'required',    
            ]);

            DB::table('vouchers')->insert([
                'nama_voucher' => $nama_voucher,
                'tipe_voucher' => $tipe_voucher,
                'target_metode_pembelian' => $target_metode_pembelian,
                'potongan' => $potongan,
                'minimal_pengambilan' => $minimal_pengambilan,
                'maksimal_pemotongan' => $potongan,
                'tanggal_berlaku' => $tanggal_berlaku,
                'tanggal_batas_berlaku' => $tanggal_batas_berlaku,
                'is_deleted' => 0,
            ]);
        }

        return redirect('./voucher');
    }


    /**
     * Menghapus voucher pada tabel " vouchers ".
     */

    public function HapusVoucher($voucher_id)
    {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
            
            if(isset($cek_admin_id)){
                DB::table('vouchers')->where('voucher_id', $voucher_id)->update([
                    'is_deleted' => 1,
                ]);
                
                return redirect('./voucher');
            }
        }
    }
}

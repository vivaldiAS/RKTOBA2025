<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class SpesifikasiController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh tipe spesifikasi yang ditambahkan.
     */

    public function tipe_spesifikasi() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                $specification_types = DB::table('specification_types')->orderBy('nama_jenis_spesifikasi', 'asc')->get();

                return view('admin.tipe_spesifikasi')->with('specification_types', $specification_types)
                ->with('cek_admin_id', $cek_admin_id);
            }
        }
    }


    /**
     * Menyimpan penambahkan tipe spesifikasi ke dalam tabel " specification_types ".
     */

    public function PostTambahTipeSpesifikasi(Request $request) {
        $nama_jenis_spesifikasi = $request -> nama_jenis_spesifikasi;

        DB::table('specification_types')->insert([
            'nama_jenis_spesifikasi' => $nama_jenis_spesifikasi,
        ]);

        return redirect('./tipe_spesifikasi');
    }


    /**
     * Menyimpan perubahan tipe spesifikasi pada tabel " specification_types ".
     */

    public function PostEditTipeSpesifikasi(Request $request, $specification_type_id) {
        $nama_jenis_spesifikasi = $request -> nama_jenis_spesifikasi;

        DB::table('specification_types')->where('specification_type_id', $specification_type_id)->update([
            'nama_jenis_spesifikasi' => $nama_jenis_spesifikasi,
        ]);

        return redirect('./tipe_spesifikasi');
    }
    

    /**
     * Menampilkan halaman daftar seluruh spesifikasi untuk tipe spesifikasi.
     */
    
    public function spesifikasi() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                $specifications = DB::table('specifications')->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->orderBy('specification_id', 'asc')->get();
                $specification_types = DB::table('specification_types')->orderBy('nama_jenis_spesifikasi', 'asc')->get();

                return view('admin.spesifikasi')->with('specifications', $specifications)->with('specification_types', $specification_types)
                ->with('cek_admin_id', $cek_admin_id);
            }
        }
    }


    /**
     * Menyimpan penambahkan spesifikasi ke dalam tabel " specifications ".
     */

    public function PostTambahSpesifikasi(Request $request) {
        $specification_type_id = $request -> specification_type_id;
        $nama_spesifikasi = $request -> nama_spesifikasi;

        DB::table('specifications')->insert([
            'specification_type_id' => $specification_type_id,
            'nama_spesifikasi' => $nama_spesifikasi,
        ]);

        return redirect('./spesifikasi');
    }


    /**
     * Menyimpan perubahan spesifikasi pada tabel " specifications ".
     */

    public function PostEditSpesifikasi(Request $request, $specification_id) {
        $specification_type_id = $request -> specification_type_id;
        $nama_spesifikasi = $request -> nama_spesifikasi;

        DB::table('specifications')->where('specification_id', $specification_id)->update([
            'specification_type_id' => $specification_type_id,
            'nama_spesifikasi' => $nama_spesifikasi,
        ]);

        return redirect('./spesifikasi');
    }
}

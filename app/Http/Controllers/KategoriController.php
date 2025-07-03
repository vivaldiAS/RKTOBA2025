<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh kategori yang ditambahkan.
     */

    public function kategori_produk() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                $categories = DB::table('categories')->orderBy('nama_kategori', 'asc')->where('type', null)->get();

                return view('admin.kategori_produk')->with('categories', $categories)->with('cek_admin_id', $cek_admin_id);
            }
        }
    }

    public function sub_kategori_produk() {
        // if(Auth::check()){
        //     $id = Auth::user()->id;
        //     $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
            
        //     if(isset($cek_admin_id)){
                $sub_categories = DB::table('sub_categories')->orderBy('nama_sub_kategori', 'asc')->get();

                return view('admin.sub_kategori_produk')->with('sub_categories', $sub_categories);
        //     }
        // }
    }

    
    /**
     * Menyimpan penambahkan kategori ke dalam tabel " categories ".
     */

    public function PostTambahKategoriProduk(Request $request) {
        $nama_kategori = $request -> nama_kategori;

        DB::table('categories')->insert([
            'nama_kategori' => $nama_kategori,
        ]);

        return redirect('./kategori_produk');
    }

    public function PostTambahSubKategoriProduk(Request $request) {
        $nama_sub_kategori = $request -> nama_sub_kategori;
        $category_id = $request -> category_id;

        DB::table('sub_categories')->insert([
            'nama_sub_kategori' => $nama_sub_kategori,
            'category_id' => $category_id,
        ]);

        return redirect('./sub_kategori_produk');
    }

    
    /**
     * Menyimpan perubahan kategori pada tabel " categories ".
     */

    public function PostEditKategoriProduk(Request $request, $kategori_produk_id) {
        $nama_kategori = $request -> nama_kategori;

        DB::table('categories')->where('category_id', $kategori_produk_id)->update([
            'nama_kategori' => $nama_kategori,
        ]);

        return redirect('./kategori_produk');
    }

    
    /**
     * Menampilkan halaman daftar seluruh kebutuhan kategori dengan tipe spesifikasi yang ditambahkan.
     */
    
    public function kategori_tipe_spesifikasi() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();
            
            if(isset($cek_admin_id)){
                $category_type_specifications = DB::table('category_type_specifications')
                ->join('categories', 'category_type_specifications.category_id', '=', 'categories.category_id')
                ->join('specification_types', 'category_type_specifications.specification_type_id', '=', 'specification_types.specification_type_id')
                ->where('type', null)
                ->orderBy('category_type_specification_id', 'asc')->get();

                $categories = DB::table('categories')->orderBy('nama_kategori', 'asc')->where('type', null)->get();
                $specification_types = DB::table('specification_types')->orderBy('nama_jenis_spesifikasi', 'asc')->get();

                // tipe data string
                $specification_type_id = DB::table('category_type_specifications')->select('specification_type_id')->get();

                // tipe data arr
                $specification_type_id_arr = explode(",", $specification_type_id);

                $nama_jenis_spesifikasi = explode(",", DB::table('category_type_specifications')->select('nama_jenis_spesifikasi')
                ->join('specification_types', 'category_type_specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get());

                return view('admin.kategori_tipe_spesifikasi')->with('category_type_specifications', $category_type_specifications)
                ->with('categories', $categories)->with('specification_types', $specification_types)->with('nama_jenis_spesifikasi', $nama_jenis_spesifikasi)
                ->with('cek_admin_id', $cek_admin_id);
            }
        }
    }
    

    /**
     * Menyimpan penambahan kebutuhan kategori dengan tipe spesifikasi ke dalam tabel " category_type_specifications ".
     */
    
    public function PostTambahKategoriTipeSpesifikasi(Request $request) {
        $request -> validate([
            'category_id' => 'required|unique:category_type_specifications',
            'specification_type_id' => 'required',
        ]);

        $category_id = $request -> category_id;
        $specification_type_id = $request -> specification_type_id;

        $jumlah_specification_type_id_dipilih = count($specification_type_id);

        for($x=0;$x<$jumlah_specification_type_id_dipilih;$x++){
            DB::table('category_type_specifications')->insert([
                'category_id' => $category_id,
                'specification_type_id' => $specification_type_id[$x],
            ]);
        }

        return redirect('./kategori_tipe_spesifikasi');
    }


    /**
     * Menyimpan perubahan kebutuhan kategori dengan tipe spesifikasi yang ditambahkan.
     */

    public function PostEditKategoriTipeSpesifikasi(Request $request, $category_type_specification_id) {
        $specification_type_id = $request -> specification_type_id;

        DB::table('category_type_specifications')->where('category_type_specification_id', $category_type_specification_id)->update([
            'specification_type_id' => implode("", $specification_type_id),
        ]);

        return redirect('./kategori_tipe_spesifikasi');
    }

    /**
     * Menampilkan halaman daftar kategori yang dapat dipilih untuk dapat menambahkan produk.
     */

    public function pilih_kategori() {
        $categories = DB::table('categories')->orderBy('nama_kategori', 'asc')->get();

        return view('user.toko.pilih_kategori')->with('categories', $categories);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class AlamatController extends Controller
{
    /**
     * Menampilkan halaman form untuk menambahkan alamat.
     */

    public function alamat(Request $request)
    {
        // Akan menampilkan halaman form untuk menambahkan alamat toko.

        if (Session::get('toko')) {
            return view('user.toko.alamat');        
        }
        

        // Akan memberikan kondisi lain jika kondisi diatas tidak terpenuhi.

        else {
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->where('is_admin', 1)->first();


            //Tidak berlaku untuk admin

            if ($cek_admin_id) {

            }
            

            // Akan menampilkan halaman form untuk menambahkan alamat pengguna.

            else {
                $user_id = Auth::user()->id;

                $product = $request->product;

                return view('user.alamat')->with('product', $product);
            }
        }
    }


    /**
     * Mengambil data lokasi dan akan digunakan untuk dapat menambahkan alamat.
     */

    public function ambil_lokasi(Request $request)
    {
        $curl = curl_init();


        // Memproses pengambilan data dari API RAJAONGKIR

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/" . $request->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return response()->json($response);
    }


    /**
     * Menyimpan penambahan alamat ke dalam tabel " merchant_address ".
     */

    public function PostAlamat(Request $request)
    {
        $province_id = $request->province;
        $province_name = $request->province_name;
        $city_id = $request->city;
        $city_name = $request->city_name;
        $subdistrict_id = $request->subdistrict;
        $subdistrict_name = $request->subdistrict_name;
        $street_address = $request->street_address;

        echo ("<script> console.log('$province_name') </script>");

        $product = $request->product;

        if (Session::get('toko')) {
            $toko = Session::get('toko');


            DB::table('merchant_address')->insert([
                'merchant_id' => $toko,
                'province_id' => $province_id,
                'city_name' => $city_name,
                'province_name' => $province_name,
                'subdistrict_name' => $subdistrict_name,
                'city_id' => $city_id,
                'subdistrict_id' => $subdistrict_id,
                'merchant_street_address' => $street_address,
            ]);

        }
        

        // Akan memberikan kondisi lain jika kondisi diatas tidak terpenuhi.

        else {
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->where('is_admin', 1)->first();


            //tidak berlaku untuk admin

            if ($cek_admin_id) {

            } 
            

            // Akan menambahkan data alamat pada tabel " user_address " untuk alamat pengguna.

            else {
                $id = Auth::user()->id;
                DB::table('user_address')->insert([
                    'user_id' => $id,
                    'province_id' => $province_id,
                    'city_id' => $city_id,
                    'city_name' => $city_name,
                    'province_name' => $province_name,
                    'subdistrict_name' => $subdistrict_name,
                    'subdistrict_id' => $subdistrict_id,
                    'user_street_address' => $street_address,
                    'is_deleted' => 0,
                ]);
            }
        }


        // Jika sebelumnya berada dihalaman lihat produk, maka akan kembali ke halaman lihat produk tersebut.

        if ($product) {
            return redirect("./lihat_produk/$product");
        }

        return redirect('./daftar_alamat');
    }


    /**
     * Menampilkan halaman daftar alamat yang telah ditambahkan.
     */
    
    public function daftar_alamat()
    {
        // set logout saat habis session dan auth

        if (!Auth::check()) {
            return redirect("./logout");
        }


        // Menampilkan halaman daftar alamat toko.
        
        if (Session::get('toko')) {
            $toko = Session::get('toko');
            $merchant_address = DB::table('merchant_address')->where('merchant_id', $toko)->first();

            $cek_merchant_address = DB::table('merchant_address')->where('merchant_id', $toko)->count();


            // Jika alamat tidak ada, maka akan menampilkan halaman form untuk menambahkan alamat.

            if ($cek_merchant_address == 0) {
                return redirect('./alamat');
            }

            
            // Selain itu maka akan menampilkan halaman daftar alamat toko

            else {
                return view('user.toko.daftar_alamat')->with('merchant_address', $merchant_address);
            }
        } 
        

        // Akan memberikan kondisi lain jika kondisi diatas tidak terpenuhi.

        else {
            $user_id = Auth::user()->id;

            $cek_admin_id = DB::table('users')->where('id', $user_id)->where('is_admin', 1)->first();


            //Tidak berlaku untuk admin

            if ($cek_admin_id) {

            } 
            

            // Selain itu maka akan ditandai sebai pengguna dan akan menampilkan halaman daftar alamat pengguna.

            else {
                $user_id = Auth::user()->id;
                $user_address = DB::table('user_address')->where('user_id', $user_id)->where('is_deleted', 0)->orderBy('user_address_id', 'asc')->get();

                return view('user.daftar_alamat')->with('user_address', $user_address);
            }
        }
    }


    /**
     * Menghapus alamat dari tabel " merchant_address ".
     */
    
    public function HapusAlamat($address_id)
    {
        if(Auth::check()){
            // Menghapus alamat toko jika masuk sebagai toko.

            if(Session::get('toko')){
                $toko = Session::get('toko');
                
                DB::table('merchant_address')->where('merchant_address_id', $address_id)->delete();
                    
                return redirect('./daftar_alamat');
                
            }


            // Akan memberikan kondisi lain jika kondisi diatas tidak terpenuhi.

            else{
                $user_id = Auth::user()->id;

                $cek_admin_id = DB::table('users')->where('id', $user_id)->where('is_admin', 1)->first();


                // Tidak berlaku untuk admin.

                if($cek_admin_id){
                    
                }


                // Menghapus alamat pengguna jika masuk sebagai pengguna.

                else{
                    $user_id = Auth::user()->id;

                    DB::table('user_address')->where('user_address_id', $address_id)->update([
                        'is_deleted' => 1,
                    ]);
                    
                    return redirect('./daftar_alamat');
                }
            }
        }
    }


    /** 
     * get city_name and subdistrict name from api rajaongkir, and update legacy db when first compile.
     * Kebutuhan khusus untuk mengupdate alamat dengan menambahkan province_name, city_name, dan subdistrict_name.
     */
    
    public function update_all_alamat_toko(Request $request)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
        )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response);
        $tempProvince = [];

        foreach ($data->rajaongkir->results as $item) {
            $tempProvince[$item->province_id] = $item->province;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
        )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response);
        $tempCity = [];

        foreach ($data->rajaongkir->results as $item) {
            $tempCity[$item->city_id] = $item->city_name;
        }

        $items = db::table("merchant_address")->whereNull("province_name")->get();

        foreach ($items as $item) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$item->city_id&id=$item->subdistrict_id",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
            )
            );

            $response = curl_exec($curl);
            curl_close($curl);

            $data = json_decode($response);
            
            db::table("merchant_address")->where("merchant_address_id", $item->merchant_address_id)->update([
                "province_name" => $tempProvince[$item->province_id],
                "city_name"=>$tempCity[$item->city_id],
                "subdistrict_name" => $data->rajaongkir->results->subdistrict_name
            ]);
        }
        return response()->json($data);
    }

    public function update_all_alamat_pengguna(Request $request) {
        $user_address = DB::table('user_address')->orderBy('user_address_id', 'asc')->get();

        foreach($user_address as $get_user_address){
            $curl = curl_init();
        
            $param = $get_user_address->city_id;
            $subdistrict_id = $get_user_address->subdistrict_id;
            
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=".$param,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array("key: 41df939eff72c9b050a81d89b4be72ba"),
            ));

            $response = curl_exec($curl);
            $collection = json_decode($response, true);
            $filters =  array_filter($collection['rajaongkir']['results'], function($r) use ($subdistrict_id) {
                return $r['subdistrict_id'] == $subdistrict_id;
            });
            
            foreach ($filters as $filter){
                $alamat_pengguna = $filter;
            }
            
            $err = curl_error($curl);
            curl_close($curl);

            DB::table('user_address')->where('user_address_id', $get_user_address->user_address_id)->update([
                'province_name' => $alamat_pengguna["province"],
                'city_name' => $alamat_pengguna["city"],
                'subdistrict_name' => $alamat_pengguna["subdistrict_name"],
            ]);
        }
    }
}
<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class AlamatController extends Controller{
  
    public function EditAlamat(Request $request)
{
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated',
        ], 401);
    }

    $validated = $request->validate([
        'user_address_id' => 'required|integer',
        'province_id' => 'required|integer',
        'province_name' => 'required|string',
        'city_id' => 'required|integer',
        'city_name' => 'required|string',
        'subdistrict_id' => 'required|integer',
        'subdistrict_name' => 'required|string',
        'user_street_address' => 'required|string',
    ]);

    $alamat = DB::table('user_address')
        ->where('user_address_id', $request->user_address_id)
        ->where('user_id', $user->id) // memastikan alamat milik user tersebut
        ->update([
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,
            'city_id' => $request->city_id,
            'city_name' => $request->city_name,
            'subdistrict_id' => $request->subdistrict_id,
            'subdistrict_name' => $request->subdistrict_name,
            'user_street_address' => $request->user_street_address,
        ]);

    if ($alamat) {
        return response()->json([
            'status' => 'success',
            'message' => 'Alamat berhasil diperbarui',
        ], 200);
    } else {
        return response()->json([
            'status' => 'error',
            'message' => 'Gagal memperbarui alamat atau alamat tidak ditemukan',
        ], 400);
    }
}

    public function AlamatPenggunas()
{
    $user = Auth::user(); // Mengambil user dari token Bearer

    if (!$user) {
        return response()->json([
            'message' => 'Unauthenticated',
        ], 401);
    }

    $alamat = DB::table('user_address')
                ->where('user_id', '=', $user->id)
                ->get();

    return response()->json([
        'alamat' => $alamat,
    ]);
}
    public function AlamatPengguna(Request $request)
    {
        $alamat = DB::table('user_address')->select('*')->where('user_id', '=', $request->user_id)->get();
        return response()->json([
            'alamat' => $alamat,
        ]);
    }

    public function TambahAlamat(Request $request)
    {
        $user_id = DB::table('user_address')->select('*')->where('user_id', '=', $request->user_id)->get();
        $user_id = $request->user_id;
        $province_id = $request->province_id;
        $province_name = $request->province_name;
        $city_id = $request->city_id;
        $city_name = $request->city_name;
        $subdistrict_id = $request->subdistrict_id;
        $subdistrict_name = $request->subdistrict_name;
        $user_street_address = $request->user_street_address;

        $user_address_id = DB::table('user_address')->insertGetId([
            'user_id' => $user_id,
            'province_id' => $province_id,
            'province_name' => $province_name,
            'city_id' => $city_id,
            'city_name' => $city_name,
            'subdistrict_id' => $subdistrict_id,
            'subdistrict_name' => $subdistrict_name,
            'user_street_address' => $user_street_address,
            'is_deleted' => 0,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Alamat berhasil ditambahkan',
            'data' => $user_address_id, 
        ], 200);
    }

    public function HapusAlamat(Request $request)
    {

        if (DB::table('user_address')->where('user_address_id', $request->user_address_id)->delete()) {
            return response()->json(
                200
            );
        }
    }

    public function AlamatToko(Request $request)
    {
        $alamat = DB::table('merchant_address')->select('*')->where('merchant_id', '=', $request->merchant_id)->get();
        return response()->json([
            'alamattoko' => $alamat,
        ]);
    }

    public function TambahAlamatToko(Request $request)
    {
        $merchant_id = DB::table('merchant_address')->select('*')->where('merchant_id', '=', $request->merchant_id)->get();
        $merchant_id = $request->merchant_id;
        $province_id = $request->province_id;
        $province_name = $request->province_name;
        $city_id = $request->city_id;
        $city_name = $request->city_name;
        $subdistrict_id = $request->subdistrict_id;
        $subdistrict_name = $request->subdistrict_name;
        $merchant_street_address = $request->merchant_street_address;

        $merchant_address_id = DB::table('merchant_address')->insertGetId([
            'merchant_id' => $merchant_id,
            'province_id' => $province_id,
            'province_name' => $province_name,
            'city_id' => $city_id,
            'city_name' => $city_name,
            'subdistrict_id' => $subdistrict_id,
            'subdistrict_name' => $subdistrict_name,
            'merchant_street_address' => $merchant_street_address,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Alamat Toko berhasil ditambahkan',
            'data' => $merchant_address_id, 
        ], 200);
    }

    public function HapusAlamatToko(Request $request)
    {

        if (DB::table('merchant_address')->where('merchant_address_id', $request->merchant_address_id)->delete()) {
            return response()->json(
                200
            );
        }
    }

    public function AlamatPenggunaPilih(Request $request)
    {
        $alamat = DB::table('user_address')->select('*')->where('user_address_id', '=', $request->user_address_id)->get();
        return response()->json([
            'alamat' => $alamat,
        ]);
    }

}   
?>
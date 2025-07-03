<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Illuminate\Support\Facades\File;

use Carbon\Carbon;

class TokoController extends Controller
{
    public function toko() {
        $user_id = Auth::user()->id;

        $cek_verifikasi = DB::table('verify_users')->where('user_id', $user_id)->first();
        $cek_verified = DB::table('verify_users')->where('user_id', $user_id)->where('is_verified', 1)->first();
        $cek_rekening = DB::table('rekenings')->where('user_id', $user_id)->first();
        $cek_merchant = DB::table('merchants')->where('user_id', $user_id)->first();
        $cek_merchant_verified = DB::table('merchants')->where('user_id', $user_id)->where('is_verified', 1)->first();

        if(Session::get('toko')){
            $merchants = DB::table('merchants')->join('users', 'merchants.user_id', '=', 'users.id')
            ->join('profiles', 'merchants.user_id', '=', 'profiles.user_id')->where('merchants.user_id', $user_id)->first();

            return view('user.toko.toko')->with('merchants', $merchants);
        }

        else{
            return view('user.toko.toko_dash')->with('cek_verifikasi', $cek_verifikasi)->with('cek_verified', $cek_verified)->with('cek_rekening', $cek_rekening)
            ->with('cek_merchant', $cek_merchant) ->with('cek_merchant_verified', $cek_merchant_verified);
        }
    }

    public function PostTambahToko(Request $request) {
        date_default_timezone_set('Asia/Jakarta');

        $id = Auth::user()->id;
        $nama_merchant = $request -> nama_merchant;
        $deskripsi_toko = $request -> deskripsi_toko;
        $kontak_toko = $request -> kontak_toko;
        $foto_merchant = $request -> file('foto_merchant');

        $nama_foto_merchant = time().'_'.$foto_merchant->getClientOriginalName();
        $tujuan_upload = './asset/u_file/foto_merchant';
        $foto_merchant->move($tujuan_upload,$nama_foto_merchant);

        DB::table('merchants')->insert([
            'user_id' => $id,
            'nama_merchant' => $nama_merchant,
            'deskripsi_toko' => $deskripsi_toko,
            'kontak_toko' => $kontak_toko,
            'foto_merchant' => $nama_foto_merchant,
            'is_closed' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect('./toko');
    }


    public function edit_toko() {
        $user_id = Auth::user()->id;

        if(Session::get('toko')){
            $toko = Session::get('toko');

            $merchants = DB::table('merchants')->join('users', 'merchants.user_id', '=', 'users.id')
            ->join('profiles', 'merchants.user_id', '=', 'profiles.user_id')->where('merchant_id', $toko)->first();

            return view('user.toko.edit_toko')->with('merchants', $merchants);
        }

        else{
            return redirect('./');;
        }
    }

    public function PostEditToko(Request $request) {
        date_default_timezone_set('Asia/Jakarta');

        $id = Auth::user()->id;

        $toko = Session::get('toko');

        $nama_merchant = $request -> nama_merchant;
        $deskripsi_toko = $request -> deskripsi_toko;
        $kontak_toko = $request -> kontak_toko;
        $foto_merchant = $request -> file('foto_merchant');

        if(!$foto_merchant){
            DB::table('merchants')->where('merchant_id', $toko)->update([
                'nama_merchant' => $nama_merchant,
                'deskripsi_toko' => $deskripsi_toko,
                'kontak_toko' => $kontak_toko,
                'updated_at' => Carbon::now(),
            ]);
        }

        if($foto_merchant){
            $merchant_lama = DB::table('merchants')->where('merchant_id', $toko)->first();
            $asal_gambar = 'asset/u_file/foto_merchant/';
            $foto_merchant_lama = public_path($asal_gambar . $merchant_lama->foto_merchant);

            if(File::exists($foto_merchant_lama)){
                File::delete($foto_merchant_lama);
            }

            $nama_foto_merchant = time().'_'.$foto_merchant->getClientOriginalName();
            $tujuan_upload = './asset/u_file/foto_merchant';
            $foto_merchant->move($tujuan_upload,$nama_foto_merchant);

            DB::table('merchants')->where('merchant_id', $toko)->update([
                'nama_merchant' => $nama_merchant,
                'deskripsi_toko' => $deskripsi_toko,
                'kontak_toko' => $kontak_toko,
                'foto_merchant' => $nama_foto_merchant,
                'updated_at' => Carbon::now(),
            ]);
        }

        return redirect('./toko');
    }

    public function MasukToko(Request $request){
        request()->validate(
            [
                'password' => 'required',
            ]);

        $user_id = Auth::user()->id;
        $password = $request->password;

        $toko = DB::table('merchants')->where('user_id', $user_id)->first();

        if(Auth::attempt(['id' => $user_id, 'password' => $password])){
            Session::put('toko', $toko->merchant_id);
            return redirect('./dashboard');
        }

        else{
            return redirect()->back();
        }
    }

    public function keluar_toko(Request $request){
        $request->session()->forget('toko');
        return redirect('./dashboard');
    }

    public function TokoUser(Request $request) {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();

            if(isset($cek_admin_id)){
                $merchants = DB::table('merchants')->join('users', 'merchants.user_id', '=', 'users.id')
                ->join('profiles', 'merchants.user_id', '=', 'profiles.user_id')->orderBy('merchant_id', 'desc')->get();

                return view('admin.toko_user')->with('merchants', $merchants)->with('cek_admin_id', $cek_admin_id);
            }
        }
    }

    public function VerifyToko($merchant_id) {
        DB::table('merchants')->where('merchant_id', $merchant_id)->update([
            'is_verified' => 1,
        ]);

        return redirect('./toko_user');
    }

    public function close_merchant_modal(Request $request, $merchant_id){
        $merchant = null;
        $merchant = DB::table("merchants")->where("merchant_id", $merchant_id)->first();
            
        return response()->json([
            "merchant" => $merchant,
        ], 200);
    }

    public function tutup_toko($merchant_id) {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1])->first();
            
            if(isset($cek_admin_id)){
                DB::table('merchants')->where('merchant_id', $merchant_id)->update([
                    'is_closed' => 1,
                ]);
        
                return redirect('./toko_user');
            }
        }
    }
}

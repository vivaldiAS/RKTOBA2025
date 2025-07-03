<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
class DaftarTokoController extends Controller
{
    //
    public function PostVerifikasi(Request $request)
    {
        $foto_ktp = $request->file('foto_ktp');
        $ktp_dan_selfie = $request->file('ktp_dan_selfie');

        $nama_foto_ktp = time() . '_' . $foto_ktp->getClientOriginalName();
        $tujuan_upload = './asset/u_file/foto_ktp';
        $foto_ktp->move($tujuan_upload, $nama_foto_ktp);

        $nama_ktp_selfie = time() . '_' . $ktp_dan_selfie->getClientOriginalName();
        $tujuan_upload = './asset/u_file/foto_ktp_selfie';
        $ktp_dan_selfie->move($tujuan_upload, $nama_ktp_selfie);

        DB::table('verify_users')->insert([
            'user_id' => $request->user_id,
            'foto_ktp' => $nama_foto_ktp,
            'ktp_dan_selfie' => $nama_ktp_selfie,
        ]);

        return response()->json(
            200
        );
    }

    public function cekVerifikasi(Request $request)
    {
        $cek_user =  DB::table('verify_users')->where('user_id', $request->user_id)->get();
        $cek_verifikasi = DB::table('verify_users')->where('user_id', $request->user_id)->where('is_verified', null)->get();

        $cek_bank = DB::table('rekenings')->where('user_id', $request->user_id)->get();
        if ($cek_user->count() > 0) {
            //jika sudah terverifikasi akun
            if ($cek_verifikasi->count() == 0) {
                $cek_bank = DB::table('rekenings')->where('user_id', $request->user_id)->get();
                //belum mendaftarkan bank
                if ($cek_bank->count() == 0) {
                    return response()->json(
                        0
                    );
                    //sudah mendaftarkan ke bank
                } elseif ($cek_bank->count() > 0) {
                    $cek_toko = DB::table('merchants')->where('user_id', $request->user_id)->get();
                    //belum mendaftarkan toko
                    if ($cek_toko->count() == 0) {
                        return response()->json(
                            1
                        );
                        //sudah mendaftarkan toko dan menunggu konfirmasi 
                    } elseif ($cek_toko->count() > 0) {
                        //sudah mendaftarkan toko
                        $cek_verifikasitoko = DB::table('merchants')->where('user_id', $request->user_id)->where('is_verified', null)->get();
                        //sudah verifikasi toko
                        if ($cek_verifikasitoko->count() == 0) {
                            return response()->json(
                                2
                            );
                        }
                        //belum verifikasi toko
                        elseif ($cek_verifikasitoko->count() > 0) {
                            return response()->json(
                                3
                            );
                        }
                    }
                }

                //jika belum melakukan verifikasi toko
            } elseif ($cek_verifikasi->count() > 0) {
                return response()->json(
                    4
                );
            }
            //jika belum mendaftarkan toko
        } else {
            return response()->json(
                5
            );
        }
    }

    public function PostRekening(Request $request)
    {
        $id = $request->user_id;
        $nama_bank = $request->nama_bank;
        $nomor_rekening = $request->nomor_rekening;
        $atas_nama = $request->atas_nama;

        DB::table('rekenings')->insert([
            'user_id' => $id,
            'nama_bank' => $nama_bank,
            'nomor_rekening' => $nomor_rekening,
            'atas_nama' => $atas_nama,
        ]);

        $cek_toko = DB::table('merchants')->where('user_id', $request->user_id)->get();
        //belum mendaftarkan toko
        if ($cek_toko->count() == 0) {
            return response()->json(
                1
            );
            //sudah mendaftarkan toko dan menunggu konfirmasi 
        } elseif ($cek_toko->count() > 0) {
            return response()->json(
                2
            );
        }
    }

    public function PostTambahToko(Request $request)
    {
        $id = $request->user_id;
        $nama_merchant = $request->nama_merchant;
        $deskripsi_toko = $request->deskripsi_toko;
        $kontak_toko = $request->kontak_toko;
        $foto_merchant = $request->file('foto_merchant');

        $nama_foto_merchant = time() . '_' . $foto_merchant->getClientOriginalName();
        $tujuan_upload = './asset/u_file/foto_merchant';
        $foto_merchant->move($tujuan_upload, $nama_foto_merchant);

        DB::table('merchants')->insert([
            'user_id' => $id,
            'nama_merchant' => $nama_merchant,
            'deskripsi_toko' => $deskripsi_toko,
            'kontak_toko' => $kontak_toko,
            'foto_merchant' => $nama_foto_merchant,
        ]);

        return response()->json(
            200
        );
    }

    public function MasukToko(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return response()->json(['message' => $val[0]], 400);
        }

        $user = User::where('id', $request->user_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Password tidak sesuai',
            ], 200);
        }
        return response()->json(
            200
        );
    }

    public function ubahToko(Request $request)
    {
        $toko = $request->merchant_id;
        $nama_merchant = $request->nama_merchant;
        $deskripsi_toko = $request->deskripsi_toko;
        $kontak_toko = $request->kontak_toko;
        $foto_merchant = $request->file('foto_merchant');

        if (!$foto_merchant) {
            DB::table('merchants')->where('merchant_id', $toko)->update([
                'nama_merchant' => $nama_merchant,
                'deskripsi_toko' => $deskripsi_toko,
                'kontak_toko' => $kontak_toko,
            ]);
        }

        if ($foto_merchant) {
            $merchant_lama = DB::table('merchants')->where('merchant_id', $toko)->first();
            $asal_gambar = 'asset/u_file/foto_merchant/';
            $foto_merchant_lama = public_path($asal_gambar . $merchant_lama->foto_merchant);

            if (File::exists($foto_merchant_lama)) {
                File::delete($foto_merchant_lama);
            }

            $nama_foto_merchant = time() . '_' . $foto_merchant->getClientOriginalName();
            $tujuan_upload = './asset/u_file/foto_merchant';
            $foto_merchant->move($tujuan_upload, $nama_foto_merchant);

            DB::table('merchants')->where('merchant_id', $toko)->update([
                'nama_merchant' => $nama_merchant,
                'deskripsi_toko' => $deskripsi_toko,
                'kontak_toko' => $kontak_toko,
                'foto_merchant' => $nama_foto_merchant,
            ]);
        }

        return response()->json(
            200
        );
    }
}

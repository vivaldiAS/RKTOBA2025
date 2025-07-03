<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\User;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil yang menampilkan informasi data tentang akun serta profil pengguna.
     */

    public function profil() {
        $id = Auth::user()->id;
    
        $profile = DB::table('profiles')->join('users', 'profiles.user_id', '=', 'users.id')->where('profiles.user_id', $id)->first();

        return view('user.profil')->with('profile', $profile);
    }

    /**
     * Menampilkan halaman form edit informasi data tentang akun serta profil pengguna..
     */

    public function edit_profil() {
        $id = Auth::user()->id;
    
        $profile = DB::table('profiles')->join('users', 'profiles.user_id', '=', 'users.id')->where('profiles.user_id', $id)->first();

        return view('user.edit_profil')->with('profile', $profile);
    }


    /**
     * Memproses perubahan profil pengguna pada tabel " profiles ".
     */

    public function PostEditProfil(Request $request) {
        $id = Auth::user()->id;

        $name = $request -> name;
        $gender = $request -> gender;
        $birthday = $request -> birthday;
        $no_hp = $request -> no_hp;

        DB::table('profiles')->where('user_id', $id)->update([
            'name' => $name,
            'gender' => $gender,
            'birthday' => $birthday,
            'no_hp' => $no_hp,
        ]);

        return redirect('./profil');
    }


    /**
     * Memproses perubahan akun pengguna untuk " password " pada tabel " users ".
     */
    
    public function PostEditPassword(Request $request) {
        $id = Auth::user()->id;

        $password_sekarang = $request -> password_sekarang;
        $password_baru = $request -> password_baru;

        if(Auth::attempt(['id' => $id, 'password' => $password_sekarang])){
            DB::table('users')->where('id', $id)->update([
                'password' => bcrypt($password_baru),
            ]);
            
            return redirect('./profil')->with('alert1','Password anda berhasil diubah.');
        }

        else{
            return redirect('./profil')->with('alert2','Password yang anda masukkan salah.');
        }

    }
}

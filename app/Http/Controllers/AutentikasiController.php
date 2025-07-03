<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Profile;

class AutentikasiController extends Controller
{
    /**
     * Menyimpan penambahan akun yang didaftarkan ke dalam database.
     */

    public function PostRegister(Request $request)
    {
        $request -> validate([
            'username' => 'required|unique:users',    
            'email' => 'required|email|unique:users',
            'password' => 'required',    

            'name' => 'required',    
            'no_hp' => 'required',    
            'birthday' => 'required',    
            'gender' => 'required',
            // 'g-recaptcha-response' => 'required|captcha',    
        ]);

        $data_users = $request->only(['username', 'password', 'email']);
        $data_profiles = $request->only(['name', 'no_hp', 'birthday', 'gender']);
        
        $username = $request->username;
        $email = $request->email;
        $password = $request->password;


        // Menambahkan data ke dalam tabel " users ".

        $users  = User::create($data_users);

        $user = User::where('username', $data_users['username'])->pluck('id');
        $id_user = $user[0];

        $data_profiles += ['user_id' => $id_user];

        
        // Menambahkan data ke dalam tabel " profiles "

        $profiles  = Profile::create($data_profiles);


        // Langsung masuk menggunakan akun yang berhasil didaftarkan.

        if(Auth::attempt(['username' => $username, 'password' => $password]) || Auth::attempt(['email' => $email, 'password' => $password])){
            $user = Auth::user();
            return redirect()->back();
        }
        

        // Akan memuat ulang halaman dan memberikan pemberitahuan jika tidak berhasil mendaftarkan akun.
        else{
            return redirect()->back()->with('error', '');
        }
    }

    
    /**
     * Memproses permintaan masuk ke aplikasi menggunakan akun yang telah didaftarkan.
     */

    public function PostLogin(Request $request){

        request()->validate(
            [
                'username_email' => 'required',
                'password' => 'required',
            ]);

        $username_email = $request->username_email;
        $password = $request->password;


        // Memeriksa akun dan akan masuk ke aplikasi dengan akun tersebut.

        if(Auth::attempt(['username' => $username_email, 'password' => $password]) || Auth::attempt(['email' => $username_email, 'password' => $password])){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
            $cek_admin_delshop = DB::table('users')->where('id', $id)->where('is_admin', 2)->first();

            $user = Auth::user();

            
            // Akan masuk sebagai admin jika kondisi terpenuhi.

            if(isset($cek_admin_id)){
                return redirect('./');
            }

            if(isset($cek_admin_delshop)){
                return redirect('./admin/delshop');
            }

            // Akan masuk sebagai pengguna jika kondisi tidak ada kondisi yang terpenuhi.   

            else{
                return redirect()->back();
            }
        }


        // Akan memuat ulang halaman dan memberikan pemberitahuan jika tidak ada kondisi yang terpenuhi.
        
        else{
            return redirect()->back()->with('error', '');
        }          
    }


    /**
     * Keluarkan akun pengguna dari aplikasi.
     */

    public function Logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('./');
    }

     /**
     * Menampilkan formulir untuk permintaan reset password.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Mengirimkan email reset password.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Menampilkan formulir untuk reset password.
     */
    public function showResetPasswordForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    /**
     * Memproses reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect('./')->with('status', __($status));
        } else {
            return back()->withErrors(['email' => [__($status)]]);
        }
    }

}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class AutentikasiController extends Controller
{
    //
public function Register(Request $request)
{
    $request->validate([
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'name' => 'required',
        'no_hp' => 'required',
        'birthday' => 'required',
        'gender' => 'required',
    ]);

    // Simpan ke tabel users (tanpa bcrypt)
    $user = User::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => $request->password, // ⛔ plaintext, sesuai permintaan
    ]);

    // Simpan ke tabel profiles
    $profile = Profile::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'no_hp' => $request->no_hp,
        'birthday' => $request->birthday,
        'gender' => $request->gender,
    ]);

    // Login otomatis (pakai Auth::attempt)
    Auth::attempt(['username' => $request->username, 'password' => $request->password]);

    // Generate token (untuk API)
    $token = $user->createToken('MyApp')->plainTextToken;

    // ⚠️ Jangan ubah format response ini!
    return response()->json([
        'token' => $token,
        'user' => [
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'name' => $profile->name
        ]
    ], 200);
}




    public function PostLogin(Request $request)
    {

        $validasi = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return response()->json(['message' => $val[0]], 400);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => $user->password,
            ], 200);
        }

        $token =  $user->createToken('MyApp')->plainTextToken;
        return response()->json([
            'token' => $token,
        ], 200);
        
    }

    public function cekLogin(Request $request)
{
    $validasi = Validator::make($request->all(), [
        'username' => 'required',
        'password' => 'required',
    ]);

    if ($validasi->fails()) {
        $val = $validasi->errors()->all();
        return response()->json(['message' => $val[0]], 400);
    }

    $user = User::where('username', $request->username)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Username atau password salah.'], 401);
    }

    // Periksa apakah pengguna adalah admin
    if ($user->is_admin != 1) {
        return response()->json(['message' => 'Hanya admin yang diizinkan untuk login.'], 403);
    }

    // Jika pengguna adalah admin, buat token dan kembalikan respons
    $token = $user->createToken('MyApp')->plainTextToken;
    return response()->json(['token' => $token], 200);
}
}
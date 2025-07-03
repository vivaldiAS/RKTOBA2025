<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = $request->user(); // get the authenticated user object from the request
        $user_id = $users->id; // get the ID of the user

        $user = DB::table('users')
            ->where('users.id', '=', $user_id)
            ->join('profiles', 'profiles.user_id', '=', 'users.id')
            ->get()
            ->map(function ($item) {
                $item->birthday = \Carbon\Carbon::createFromFormat('Y-m-d', $item->birthday)->format('d-m-Y');
                $item->gender = ($item->gender == 'P') ? 'Perempuan' : 'Laki-laki';
                return $item;
            });
        return response()->json($user);
    }


    public function PostEditProfil(Request $request)
    {
        $birthday = \Carbon\Carbon::createFromFormat('d-m-Y', $request->birthday)->format('Y-m-d');
        $gender = ($request->gender == 'Perempuan') ? 'P' : 'L';
        DB::table('profiles')->where('user_id', $request->user_id)->update([
            'name' => $request->name,
            'gender' => $gender,
            'birthday' => $birthday,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json(
            200
        );
    }

    public function ubahPassword(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required',
            'password_baru' => 'required',
        ]);

        if ($validasi->fails()) {
            $val = $validasi->errors()->all();
            return response()->json(['message' => $val[0]], 400);
        }

        $user = User::where('id', $request->user_id)->first();
        $password = Hash::make($request->password_baru);

        if ($request->password == $request->password_baru) {
            return response()->json(['message' => 'Password lama dan password baru sama. Silahkan isi password baru yang berbeda!'], 400);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password lama salah. Silahkan isi kembali password Anda!'], 400);
        }

        DB::table('users')->where('id', $request->user_id)->update([
            'password' => $password,
        ]);

        return response()->json(['message' => "Password berhasil diganti"]);
    }

    public function hapusAkun(Request $request)
    {

        DB::table('users')
        ->where('id', $request->id)
        ->update([
            'is_banned' => 1
        ]);

        return response()->json([
            'message' => 'User account banned successfully'
        ], 200);

    }

}

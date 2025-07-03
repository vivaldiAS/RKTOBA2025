<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Carbon\Carbon;

class ObrolanController extends Controller
{
    public function chat() {
        if (Auth::check()) {
            $id = null;

            if (Session::get('toko')) {
                $get_toko = Session::get('toko');

                $count_ready_chat = DB::table('chat_user_merchants')
                    ->where('id_to', $get_toko)
                    ->count();

                $ready_chat = DB::table('chat_user_merchants')
                    ->select('id_from as id', 'username', DB::raw('MAX(chat_user_merchants.created_at) as latest_created_at'))
                    ->where('id_to', $get_toko)
                    ->groupBy('id_from', 'username')
                    ->join('users', 'chat_user_merchants.id_from', '=', 'users.id')
                    ->orderBy('latest_created_at', 'asc')
                    ->get();

                return view('user.toko.chat', compact('count_ready_chat', 'ready_chat', 'id', 'get_toko'));
            } else {
                $get_toko = null;
                $user_id = Auth::user()->id;

                $count_ready_chat = DB::table('chat_user_merchants')
                    ->where('id_from', $user_id)
                    ->count();

                $ready_chat = DB::table('chat_user_merchants')
                    ->select('id_to as merchant_id', 'nama_merchant', DB::raw('MAX(chat_user_merchants.created_at) as latest_created_at'))
                    ->where('id_from', $user_id)
                    ->groupBy('id_to', 'nama_merchant')
                    ->join('merchants', 'chat_user_merchants.id_to', '=', 'merchants.merchant_id')
                    ->orderBy('latest_created_at', 'asc')
                    ->get();

                return view('user.chat', compact('count_ready_chat', 'ready_chat', 'id', 'get_toko'));
            }
        }

        return redirect("./logout");
    }

    public function chatting($id) {
        if (Auth::check()) {
            if (Session::get('toko')) {
                $get_toko = Session::get('toko');

                $count_ready_chat = DB::table('chat_user_merchants')
                    ->where('id_to', $get_toko)
                    ->count();

                $ready_chat = DB::table('chat_user_merchants')
                    ->select('id_from as id', 'username', DB::raw('MAX(chat_user_merchants.created_at) as latest_created_at'))
                    ->where('id_to', $get_toko)
                    ->groupBy('id_from', 'username')
                    ->join('users', 'chat_user_merchants.id_from', '=', 'users.id')
                    ->orderBy('latest_created_at', 'asc')
                    ->get();

                $chatting = DB::table('chat_user_merchants')
                    ->where(function ($query) use ($get_toko, $id) {
                        $query->where('id_from', $get_toko)
                            ->where('id_to', $id);
                    })
                    ->orWhere(function ($query) use ($get_toko, $id) {
                        $query->where('id_from', $id)
                            ->where('id_to', $get_toko);
                    })
                    ->orderBy('chat_user_merchant_id', 'asc')
                    ->get();

                $user = DB::table('users')->where('id', $id)->first();

                return view('user.toko.chat', compact('count_ready_chat', 'ready_chat', 'chatting', 'user', 'id', 'get_toko'));
            } else {
                $get_toko = null;
                $user_id = Auth::user()->id;

                $count_ready_chat = DB::table('chat_user_merchants')
                    ->where('id_from', $user_id)
                    ->count();

                $ready_chat = DB::table('chat_user_merchants')
                    ->select('id_to as merchant_id', 'nama_merchant', DB::raw('MAX(chat_user_merchants.created_at) as latest_created_at'))
                    ->where('id_from', $user_id)
                    ->groupBy('id_to', 'nama_merchant')
                    ->join('merchants', 'chat_user_merchants.id_to', '=', 'merchants.merchant_id')
                    ->orderBy('latest_created_at', 'asc')
                    ->get();

                $chatting = DB::table('chat_user_merchants')
                    ->where(function ($query) use ($user_id, $id) {
                        $query->where('id_from', $user_id)
                            ->where('id_to', $id);
                    })
                    ->orWhere(function ($query) use ($user_id, $id) {
                        $query->where('id_from', $id)
                            ->where('id_to', $user_id);
                    })
                    ->orderBy('chat_user_merchant_id', 'asc')
                    ->get();

                $merchant = DB::table('merchants')->where('merchant_id', $id)->first();

                return view('user.chat', compact('count_ready_chat', 'ready_chat', 'chatting', 'merchant', 'id', 'get_toko'));
            }
        }

        return redirect("./logout");
    }

    public function PostChatting(Request $request, $id) {
        if (Auth::check()) {
            $isi_chat = $request->isi_chat;
            $timestamp = Carbon::now();

            if (Session::get('toko')) {
                $get_toko = Session::get('toko');

                DB::table('chat_user_merchants')->insert([
                    'id_from' => $get_toko,
                    'id_to' => $id,
                    'pengirim' => 'merchant',
                    'isi_chat' => $isi_chat,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                return redirect("./chat/$id");
            } else {
                $user_id = Auth::user()->id;

                DB::table('chat_user_merchants')->insert([
                    'id_from' => $user_id,
                    'id_to' => $id,
                    'pengirim' => 'user',
                    'isi_chat' => $isi_chat,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                return redirect("./chat/$id");
            }
        }

        return redirect("./logout");
    }
}
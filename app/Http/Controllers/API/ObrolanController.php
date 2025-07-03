<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ObrolanController extends Controller
{
public function getChats()
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $id = null;
    if (Session::get('toko')) {
        $get_toko = Session::get('toko');
        $count_ready_chat = DB::table('chat_user_merchants')->where('id_to', $get_toko)->count();

        $ready_chat = DB::table('chat_user_merchants')
            ->select(
                'id_from as id', 
                'username', 
                DB::raw('(SELECT isi_chat FROM chat_user_merchants WHERE chat_user_merchants.id_from = users.id AND chat_user_merchants.id_to = '.$get_toko.' ORDER BY created_at DESC LIMIT 1) as latest_message_text'),
                'merchants.foto_merchant' // Menambahkan foto_merchant
            )
            ->where('id_to', $get_toko)
            ->groupBy('id_from', 'username', 'merchants.foto_merchant') // Menambahkan foto_merchant ke dalam groupBy
            ->join('users', 'chat_user_merchants.id_from', '=', 'users.id')
            ->join('merchants', 'chat_user_merchants.id_to', '=', 'merchants.merchant_id') // Bergabung dengan tabel merchants untuk mengambil foto_merchant
            ->orderBy('chat_user_merchants.created_at')
            ->get();

        return response()->json([
            'count_ready_chat' => $count_ready_chat,
            'ready_chat' => $ready_chat,
            'id' => $id,
            'get_toko' => $get_toko
        ]);
    } else {
        $get_toko = null;
        $user_id = Auth::user()->id;
        $count_ready_chat = DB::table('chat_user_merchants')->where('id_from', $user_id)->count();

        $ready_chat = DB::table('chat_user_merchants')
            ->select(
                'id_to as merchant_id', 
                'nama_merchant', 
                'merchants.foto_merchant', // Menambahkan foto_merchant
                DB::raw('MAX(chat_user_merchants.created_at) as latest_message'),
                DB::raw('(SELECT isi_chat FROM chat_user_merchants WHERE chat_user_merchants.id_to = merchants.merchant_id AND chat_user_merchants.id_from = '.$user_id.' ORDER BY created_at DESC LIMIT 1) as latest_message_text')
            )
            ->where('id_from', $user_id)
            ->groupBy('id_to', 'nama_merchant', 'merchants.foto_merchant') // Menambahkan foto_merchant ke dalam groupBy
            ->join('merchants', 'chat_user_merchants.id_to', '=', 'merchants.merchant_id')
            ->orderBy('latest_message', 'desc')
            ->get();

        return response()->json([
            'count_ready_chat' => $count_ready_chat,
            'ready_chat' => $ready_chat,
            'id' => $id,
            'get_toko' => $get_toko
        ]);
    }
}

public function getChatDetail($id)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    if (Session::get('toko')) {
        $get_toko = Session::get('toko');
        $chatting = DB::table('chat_user_merchants')
            ->where(function ($query) use ($get_toko, $id) {
                $query->where('id_from', $get_toko)->where('id_to', $id)
                    ->orWhere('id_from', $id)->where('id_to', $get_toko);
            })
            ->orderBy('chat_user_merchant_id', 'asc')
            ->get();

        return response()->json([
            'chatting' => $chatting,
            'user' => DB::table('users')->where('id', $id)->first(),
            'id' => $id,
            'get_toko' => $get_toko
        ]);
    } else {
        $user_id = Auth::user()->id;
        $chatting = DB::table('chat_user_merchants')
            ->where(function ($query) use ($user_id, $id) {
                $query->where('id_from', $user_id)->where('id_to', $id)
                    ->orWhere('id_from', $id)->where('id_to', $user_id);
            })
            ->orderBy('chat_user_merchant_id', 'asc')
            ->get();

        // Mengambil data merchant termasuk foto_merchant
        $merchant = DB::table('merchants')->where('merchant_id', $id)->first();
        $merchantWithPhoto = $merchant ? array_merge((array) $merchant, ['foto_merchant' => $merchant->foto_merchant]) : null;

        return response()->json([
            'chatting' => $chatting,
            'merchant' => $merchantWithPhoto, // Mengirimkan foto_merchant
            'id' => $id
        ]);
    }
}


    public function postChat(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $isi_chat = $request->input('isi_chat');
        $timestamp = Carbon::now('Asia/Jakarta'); // Gunakan waktu lokal
    
        if (Session::get('toko')) {
            $get_toko = Session::get('toko');
    
            DB::table('chat_user_merchants')->insert([
                'id_from' => $get_toko,
                'id_to' => $id,
                'pengirim' => 'merchant',
                'isi_chat' =>    $isi_chat,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
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
        }
    
        return response()->json(['message' => 'Chat sent successfully']);
    }
    public function hapusChat($chat_id)
{
    if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Mengambil informasi chat berdasarkan chat_id
    $chat = DB::table('chat_user_merchants')->where('chat_user_merchant_id', $chat_id)->first();

    if (!$chat) {
        return response()->json(['message' => 'Chat not found'], 404);
    }

    // Mengecek apakah chat dikirim oleh pengguna yang sedang login
    $user_id = Auth::user()->id;
    if ($chat->id_from != $user_id && $chat->id_to != $user_id) {
        return response()->json(['message' => 'You are not authorized to delete this chat'], 403);
    }

    // Mengecek apakah pesan tersebut dikirim dalam rentang 24 jam
    $created_at = Carbon::parse($chat->created_at);
    if ($created_at->diffInHours(Carbon::now()) > 24) {
        return response()->json(['message' => 'Kamu hanya dapat menghapus pesan dalam 24 jam'], 400);
    }

    // Menghapus pesan chat dari database
    DB::table('chat_user_merchants')->where('chat_user_merchant_id', $chat_id)->delete();

    return response()->json(['message' => 'Chat deleted successfully']);
}
}

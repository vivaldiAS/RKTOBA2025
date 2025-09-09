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
            ->groupBy('id_to', 'nama_merchant', 'merchants.merchant_id', 'merchants.foto_merchant') // Menambahkan merchant_id ke dalam groupBy
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
public function getMerchantChats()
{
    $user = Auth::user(); // Dapatkan user dari token Bearer

    if (!$user) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    // Ambil merchant milik user yang login
    $merchant = DB::table('merchants')->where('user_id', $user->id)->first();

    if (!$merchant) {
        return response()->json([
            'message' => 'Merchant not found for this user'
        ], 404);
    }

    $merchant_id = $merchant->merchant_id;

    // Ambil daftar user yang pernah chat dengan merchant
    $chatList = DB::table('chat_user_merchants as a')
        ->selectRaw('
            CASE 
                WHEN a.id_from = ? THEN a.id_to 
                ELSE a.id_from 
            END AS user_id,
            MAX(a.created_at) as latest_time
        ', [$merchant_id])
        ->where(function ($query) use ($merchant_id) {
            $query->where('a.id_from', $merchant_id)
                  ->orWhere('a.id_to', $merchant_id);
        })
        ->groupBy('user_id')
        ->orderByDesc('latest_time')
        ->get();

    // Tambahkan detail username dan pesan terakhir
    $ready_chat = $chatList->map(function ($chat) use ($merchant_id) {
        $latestMessage = DB::table('chat_user_merchants')
            ->where(function ($q) use ($merchant_id, $chat) {
                $q->where(function ($w) use ($merchant_id, $chat) {
                    $w->where('id_from', $merchant_id)
                      ->where('id_to', $chat->user_id);
                })->orWhere(function ($w) use ($merchant_id, $chat) {
                    $w->where('id_from', $chat->user_id)
                      ->where('id_to', $merchant_id);
                });
            })
            ->orderByDesc('created_at')
            ->limit(1)
            ->value('isi_chat');

        $username = DB::table('users')->where('id', $chat->user_id)->value('username');

        return [
            'user_id' => $chat->user_id,
            'username' => $username,
            'latest_time' => $chat->latest_time,
            'latest_message' => $latestMessage,
        ];
    });

    return response()->json([
        'merchant_id' => $merchant->merchant_id,
        'merchant_user_id' => $merchant->user_id,
        'ready_chat' => $ready_chat
    ]);
}

public function getMerchantChatDetail($user_id)
{
    $authUserId = Auth::id(); // ID user dari token
    $merchant = DB::table('merchants')->where('user_id', $authUserId)->first();

    if (!$merchant) {
        return response()->json([
            'message' => 'Merchant not found for this user'
        ], 404);
    }

    // Ambil semua chat antara merchant dan user tertentu
    $chatMessages = DB::table('chat_user_merchants')
        ->where(function ($q) use ($merchant, $user_id) {
            $q->where('id_from', $merchant->merchant_id)
              ->where('id_to', $user_id);
        })->orWhere(function ($q) use ($merchant, $user_id) {
            $q->where('id_from', $user_id)
              ->where('id_to', $merchant->merchant_id);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json([
        'merchant_id' => $merchant->merchant_id,
        'merchant_user_id' => $merchant->user_id,
        'chat_with_user_id' => $user_id,
        'messages' => $chatMessages,
    ]);
}

public function sendMerchantMessage(Request $request, $user_id)
{
    // Validasi input
    $request->validate([
        'isi_chat' => 'required|string',
    ]);

    // Ambil user yang login dari token
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    // Ambil merchant berdasarkan user_id
    $merchant = DB::table('merchants')->where('user_id', $user->id)->first();

    if (!$merchant) {
        return response()->json([
            'message' => 'Merchant not found for this user'
        ], 404);
    }

    // Simpan pesan
    DB::table('chat_user_merchants')->insert([
        'id_from'    => $merchant->merchant_id,
        'id_to'      => $user_id,
        'pengirim'   => 'merchant',
        'isi_chat'   => $request->isi_chat,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return response()->json([
        'message' => 'Pesan berhasil dikirim'
    ], 200);
}
}

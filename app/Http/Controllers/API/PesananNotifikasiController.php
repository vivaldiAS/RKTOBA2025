<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananNotifikasiController extends Controller
{
    public function getUserNotifications()
    {
        $user = Auth::user();

        // Ambil notifikasi pesanan yang belum dibaca
        $notifications = DB::table('notifikasipesanan')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Format notifikasi
        $formattedNotifications = $notifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'purchase_id' => $notification->purchase_id,
                'created_at' => $notification->created_at,
                'status' => $notification->status
            ];
        });

        return response()->json($formattedNotifications);
    }

   public function markAsRead($id)
{
    // Tandai notifikasi sebagai sudah dibaca
    $notification = DB::table('notifikasipesanan')
        ->where('id', $id)
        ->update(['status' => 'read', 'updated_at' => now()]);

    return response()->json(['message' => 'Notifikasi berhasil dibaca']);
}
   
}

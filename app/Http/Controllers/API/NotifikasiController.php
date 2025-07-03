<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\ProductPurchasedNotification;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function getUserNotifications()
    {
        $user = Auth::user();

        $notifications = $user->notifications()->orderBy('created_at', 'desc')->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->data['title'],
                'message' => $notification->data['message'],
                'purchase_id' => $notification->data['purchase_id'],
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at,
            ];
        });

        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        $notification->markAsRead();

        return response()->json(['message' => 'Notifikasi berhasil dibaca']);
    }

    public function sendProductPurchasedNotification($merchant_id, $purchase_id)
    {
        $merchantUser = User::find($merchant_id);

        $productPurchase = DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->where('purchase_id', $purchase_id)
            ->select('products.name as product_name')
            ->first();

        if ($merchantUser && $productPurchase) {
            $merchantUser->notify(new ProductPurchasedNotification($purchase_id, $productPurchase->product_name));
        }
    }
}   
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ProductPurchase;
use App\Notifications\ProductPurchasedNotification;
use App\Notifications\OrderStatusUpdateNotification;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    /**
     * Mengambil semua notifikasi untuk pengguna yang sedang login.
     */
    public function getUserNotifications()
    {
        $user = Auth::user();

        // Ambil semua notifikasi dan urutkan berdasarkan waktu
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

    /**
     * Menandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);

        // Tandai notifikasi sebagai sudah dibaca
        $notification->markAsRead();

        return response()->json(['message' => 'Notifikasi berhasil dibaca']);
    }

    /**
     * Mengirim notifikasi ke merchant saat ada pembelian produk.
     */
    public function sendProductPurchasedNotification($merchant_id, $purchase_id)
    {
        $merchantUser = User::find($merchant_id);

        if (!$merchantUser) {
            return response()->json(['message' => 'Merchant tidak ditemukan'], 404);
        }

        // Mengambil nama produk dari tabel products berdasarkan purchase_id
        $productPurchase = DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->where('purchase_id', $purchase_id)
            ->select('products.product_name as product_name') // Pastikan menggunakan field yang benar
            ->first();

        if (!$productPurchase) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Kirim notifikasi ke merchant
        $merchantUser->notify(new ProductPurchasedNotification($purchase_id, $productPurchase->product_name));

        return response()->json(['message' => 'Notifikasi berhasil dikirim ke merchant']);
    }

    /**
     * Mengirim notifikasi ke pembeli ketika status pesanan diperbarui.
     */
    public function updateOrderStatus(Request $request, $purchase_id)
    {
        // Ambil status yang dikirim dalam request
        $status = $request->status;

        // Cari pesanan berdasarkan ID
        $purchase = ProductPurchase::find($purchase_id);
        if (!$purchase) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Tentukan pesan status berdasarkan status yang diterima
        $status_message = '';
        switch ($status) {
            case 'status1':
            case 'status1_ambil':
                $status_message = 'Pembayaran Anda belum dikirim. Silakan kirim bukti pembayaran.';
                break;
            case 'status2':
            case 'status2_ambil':
                $status_message = 'Bukti pembayaran telah dikonfirmasi. Pesanan sedang dikemas.';
                break;
            case 'status3':
                $status_message = 'Pesanan Anda sedang dalam perjalanan.';
                break;
            case 'status3_ambil':
                $status_message = 'Pesanan Anda sudah siap untuk diambil di toko.';
                break;
            case 'status4_ambil_a':
                $status_message = 'Pesanan Anda telah diambil. Silakan konfirmasi bahwa pesanan telah diterima.';
                break;
            default:
                return response()->json(['message' => 'Status tidak dikenali'], 400);
        }

        // Perbarui status pesanan
        $purchase->status_pembelian = $status;
        $purchase->save();

        // Kirimkan notifikasi ke pembeli
        $this->sendOrderStatusUpdateNotification($purchase->user_id, $purchase_id, $status_message);

        return response()->json(['message' => 'Status pesanan berhasil diperbarui dan notifikasi dikirim']);
    }

    /**
     * Mengirimkan notifikasi ke pembeli ketika status pesanan diperbarui.
     */
    private function sendOrderStatusUpdateNotification($user_id, $purchase_id, $status_message)
    {
        // Cari pengguna pembeli berdasarkan ID
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'Pembeli tidak ditemukan'], 404);
        }

        // Kirimkan notifikasi ke pembeli
        $user->notify(new OrderStatusUpdateNotification($purchase_id, $status_message));
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\AutentikasiController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PengirimanController;
use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\DaftarTokoController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\RekeningController;
use App\Http\Controllers\API\PembelianController;
use App\Http\Controllers\API\StokController;
use App\Http\Controllers\API\AlamatController;
use App\Http\Controllers\API\ObrolanController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SearchHistoryController;
use App\Http\Controllers\API\NotifikasiController;
use App\Http\Controllers\Api\TokoAPIController;
use App\Http\Controllers\Api\CarouselController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/toko/{id}', [TokoAPIController::class, 'show']);
Route::get('carousels', [CarouselController::class, 'getCarousels']);

Route::middleware('auth:sanctum')->post('/alamat/edit', [AlamatController::class, 'EditAlamat']);
Route::middleware('auth:sanctum')->get('/alamat-pengguna', [AlamatController::class, 'AlamatPenggunas']);

Route::get('/image-proxy', function (Request $request) {
    $url = $request->query('url');
    if (!$url) {
        return response('Missing URL', 400);
    }

    try {
        $response = Http::get($url);
        return response($response->body(), 200)
            ->header('Content-Type', $response->header('Content-Type'));
    } catch (\Exception $e) {
        return response('Failed to fetch image', 500);
    }
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/search-history', [SearchHistoryController::class, 'index']);
    Route::post('/search-history', [SearchHistoryController::class, 'store']);
    Route::delete('/search-history/{id}', [SearchHistoryController::class, 'destroy']);
    Route::delete('/search-history', [SearchHistoryController::class, 'clear']); // hapus semua
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifikasi', [NotifikasiController::class, 'getUserNotifications']);
    Route::put('/notifikasi/{id}/read', [NotifikasiController::class, 'markAsRead']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chats', [ObrolanController::class, 'getChats']); // Ambil daftar chat
    Route::get('/chat/{id}', [ObrolanController::class, 'getChatDetail']); // Detail chat dengan user/toko
    Route::post('/chat/{id}', [ObrolanController::class, 'postChat']); // Kirim chat baru
    Route::delete('/obrolan/delete/{chat_id}', [ObrolanController::class, 'hapusChat']);
});

Route::get('/reviews/{productId}/average', [ReviewController::class, 'averageRating']);

Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{id}', [ReviewController::class, 'show']);
Route::middleware('auth:sanctum')->post('/reviews', [ReviewController::class, 'store']);


Route::get('/user', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::post('/ubahprofil', [UserController::class, 'PostEditProfil']);
Route::post('/ubahpassword', [UserController::class, 'ubahPassword']);

Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/lihat_produk', [ProdukController::class, 'lihat_produk']);

//merchants
Route::post('/tambahproduk', [ProdukController::class, 'PostTambahProduk']);
Route::get('/pilihkategori', [ProdukController::class, 'pilih_kategori']);
Route::post('/daftarproduk', [ProdukController::class, 'produk']);
Route::middleware('auth:sanctum')->get('/daftarproduktoken', [ProdukController::class, 'produkByToken']);
Route::post('/hapusproduk', [ProdukController::class, 'hapusProduk']);
Route::post('/produkdetail', [ProdukController::class, 'produk_detail']);
Route::post('/editproduk', [ProdukController::class, 'editProduk']);
Route::get('/getstock/{product_id}', [ProdukController::class, 'getStock']);
Route::post('/updatestock', [ProdukController::class, 'updateStock']);

Route::post('keranjang', [CartController::class, 'keranjang']);
Route::post('tambahkeranjang', [CartController::class, 'masuk_keranjang']);
Route::post('hapus', [CartController::class, 'hapus']);
Route::post('kurang', [CartController::class, 'kurang']);
Route::post('tambah', [CartController::class, 'tambah']);

Route::post('register', [AutentikasiController::class, 'Register']);
Route::post('login', [AutentikasiController::class, 'PostLogin']);
Route::post('postlogin', [AutentikasiController::class, 'cekLogin']);


// Route::post('pengiriman', [PengirimanController::class, 'PostBeliProduk']);
Route::middleware('auth:sanctum')->post('/checkout/multi-produk', [PengirimanController::class, 'postBeliProdukMultiProduk']);
Route::middleware('auth:sanctum')->post('/pengiriman', [PengirimanController::class, 'PostBeliProduk']);
Route::post('belilangsung', [PengirimanController::class, 'belilangsung']);
Route::post('daftar_pembelian', [PengirimanController::class, 'daftar_pembelian']);
Route::post('menunggu_pembayaran', [PengirimanController::class, 'menunggu_pembayaran']);
Route::post('detail_pesanan', [PengirimanController::class, 'detail_pesanan']);
Route::post('hapuspesanan', [PengirimanController::class, 'hapus']);
Route::post('PostBuktiPembayaran', [PengirimanController::class, 'PostBuktiPembayaran']);


//wishlist
Route::post('tambahwishlist', [WishlistController::class, 'tambahWishlist']);
Route::post('daftarwishlist', [WishlistController::class, 'daftarWishlist']);
Route::post('hapuswishlist', [WishlistController::class, 'hapusWishlist']);

//toko
Route::post('verifikasitoko', [DaftarTokoController::class, 'PostVerifikasi']);
Route::post('cekverifikasi', [DaftarTokoController::class, 'cekVerifikasi']);
Route::post('cekverifikasiToko', [DaftarTokoController::class, 'cekVerifikasi']);

Route::post('hometoko', [HomeController::class, 'dashboard']);

Route::post('postrekening', [DaftarTokoController::class, 'PostRekening']);
Route::post('posttambahtoko', [DaftarTokoController::class, 'PostTambahToko']);
Route::post('masuktoko', [DaftarTokoController::class, 'MasukToko']);
Route::post('ubahtoko', [DaftarTokoController::class, 'ubahToko']);

Route::post('profilmerchant', [MerchantController::class, 'index']);
Route::middleware('auth:sanctum')->get('profilmerchant-token', [MerchantController::class, 'profilDenganToken']);

Route::get('daftarbank', [RekeningController::class, 'daftarbank']);
Route::post('daftarrekening', [RekeningController::class, 'daftar_rekening']);
Route::post('hapusrekening', [RekeningController::class, 'HapusRekening']);

Route::post('daftarpembelian', [PembelianController::class, 'daftar_pembelian']);
Route::post('detailpembelian', [PembelianController::class, 'detail_pembelian']);
Route::post('updatestatuspembelian', [PembelianController::class, 'update_status_pembelian']);
Route::post('updatestatus2pembelian', [PembelianController::class, 'update_status2_pembelian']);

Route::post('alamatpengguna ', [AlamatController::class, 'AlamatPengguna']);
Route::post('tambahalamat ', [AlamatController::class, 'TambahAlamat']);
Route::post('hapusalamat ', [AlamatController::class, 'HapusAlamat']);

Route::post('alamattoko ', [AlamatController::class, 'AlamatToko']);
Route::post('tambahalamattoko', [AlamatController::class, 'TambahAlamatToko']);
Route::post('hapusalamattoko ', [AlamatController::class, 'HapusAlamatToko']);

Route::post('alamatpengguna_now ', [AlamatController::class, 'AlamatPenggunaPilih']);

Route::get('/pembelian', [PembelianController::class, 'daftarPembelianApi']);
Route::get('/daftartenant', [MerchantController::class, 'daftartenant']);

Route::get('/listdaftarproduk', [ProdukController::class, 'daftarproduk']);

Route::get('/stok', [StokController::class, 'index']);

use App\Http\Controllers\API\KuisionerController;

Route::get('/kuisioner', [KuisionerController::class, 'index']);
Route::post('/jawaban', [KuisionerController::class, 'simpanJawaban']);



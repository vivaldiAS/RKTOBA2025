<?php

use App\Http\Controllers\Admin\AdminGalleryController;
use App\Http\Controllers\Admin\AdminRequestGalleryController;
use App\Http\Controllers\Admin\AdminRequestWarehouseController;
use App\Http\Controllers\Admin\AdminWarehouseController;

use App\Http\Controllers\Warehouse\DashboardController;
use App\Http\Controllers\Warehouse\ProdukWarehouseController;
use App\Http\Controllers\Warehouse\TransaksiWarehouseController;
use App\Http\Controllers\Warehouse\LaporanWarehouseController;
use App\Http\Controllers\Warehouse\NotifikasiWarehouseController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TiketExperienceController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\AutentikasiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChatbotController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route untuk halaman utama pada aplikasi.
Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/admin/delshop', [HomeController::class, 'index_delshop'])->name('delshop.index');
Route::get('/admin/delshop/produk', [HomeController::class, 'produk_delshop'])->name('delshop.produk');
Route::get('/admin/delshop/produk/{id}/hapus', [HomeController::class, 'hapusproduk_delshop'])->name('admin.hapusproduk.delshop');
Route::get('/admin/delshop/produk/{id}/edit', [HomeController::class, 'editProduk'])->name('admin.editProduk.delshop');
Route::put('/admin/delshop/produk/{id}/update', [HomeController::class, 'updateProduk'])->name('admin.updateProduk.delshop');

/**
 * Fitur Autentikasi Pengguna.
 */

// Route untuk mendaftar akun baru.
Route::post('/registrasi', 'App\Http\Controllers\AutentikasiController@PostRegister');

// Route untuk masuk ke sistem dengan akun yang sudah terdaftar.
Route::post('/login', 'App\Http\Controllers\AutentikasiController@PostLogin');

/**
 *
 */


// Route untuk keluar dari akun pada sistem.
Route::get('/logout', 'App\Http\Controllers\AutentikasiController@Logout');


/*
 * Fitur Kelola Profil pada Akun Pengguna.
 * Hanya dapat diakses jika melewati " Route untuk masuk ke sistem dengan akun yang sudah terdaftar ".
 */

// Route untuk halaman profil pengguna yang menampilkan informasi pada profil pengguna.
Route::get('/profil', 'App\Http\Controllers\ProfilController@profil');

// Route untuk halaman edit pengguna.
Route::get('/edit_profil', 'App\Http\Controllers\ProfilController@edit_profil');

// Route untuk memproses permintaan edit profil pengguna.
Route::post('/PostEditProfil', 'App\Http\Controllers\ProfilController@PostEditProfil');

// Route untuk memproses permintaan edit sandi pengguna.
Route::post('/PostEditPassword', 'App\Http\Controllers\ProfilController@PostEditPassword');

/**
 *
 */


/*
 * Fitur Kelola Alamat pada Pengguna atau Toko.
 * Jika hanya masuk sebagai pengguna maka akan ditandai sebagai Pengguna.
 * Jika melewati " Route untuk masuk ke sistem sebagai Toko " maka akan ditandai sebagai Toko.
 */

// Route untuk menampilkan halaman tambah alamat pengguna atau toko.
Route::get('/alamat', 'App\Http\Controllers\AlamatController@alamat');

// Route untuk memproses permintaan tambah alamat pengguna atau toko.
Route::post('/PostAlamat', 'App\Http\Controllers\AlamatController@PostAlamat');

// Route untuk menampilkan halaman daftar alamat yang telah ditambahkan pengguna atau toko.
Route::get('/daftar_alamat', 'App\Http\Controllers\AlamatController@daftar_alamat');

// Route untuk memproses permintaan hapus alamat pengguna atau toko.
Route::get('/hapus_alamat/{address_id}', 'App\Http\Controllers\AlamatController@HapusAlamat');

/**
 *
 */


/**
 * Fitur Kelola Pengiriman Lokal pada Toko.
 * Pengiriman Lokal merupakan layanan pengiriman yang disediakan oleh toko.
 * Hanya dapat diakses jika melewati " Route untuk masuk ke sistem sebagai Toko ".
 */

// Route untuk menampilkan halaman tambah pengiriman lokal.
Route::get('/pengiriman_lokal', 'App\Http\Controllers\PengirimanLokalController@pengiriman_lokal');

// Route untuk memproses permintaan tambah pengiriman lokal.
Route::post('/PostPengirimanLokal', 'App\Http\Controllers\PengirimanLokalController@PostPengirimanLokal');

// Route untuk menampilkan halaman daftar pengiriman lokal yang telah ditambahkan pengguna atau toko.
Route::get('/daftar_pengiriman_lokal', 'App\Http\Controllers\PengirimanLokalController@daftar_pengiriman_lokal');

// Route untuk memproses permintaan hapus pengiriman lokal.
Route::get('/hapus_pengiriman_lokal/{shipping_local_id}', 'App\Http\Controllers\PengirimanLokalController@HapusPengirimanLokal');

/**
 *
 */


// Route untuk mengambil data lokasi melalui AJAX yang terdapat pada file function.js .
Route::get('/ambil_lokasi', 'App\Http\Controllers\AlamatController@ambil_lokasi');

Route::get('/', 'App\Http\Controllers\HomeController@index');


Route::get('/search-purchases', 'App\Http\Controllers\HomeController@searchPurchases')->name('admin.searchPurchases');


// Route untuk halaman utama pada aplikasi.
Route::get('/dashboard', 'App\Http\Controllers\HomeController@dashboard');


/**
 * Fitur Pengajuan Verifikasi Akun Pengguna.
 * Agar akun dari pengguna diverifikasi oleh admin agar pengguna dapat mendaftarkan tokonya.
 */

// Route untuk menampilkan halaman verifikasi untuk mengajukan verifikasi akun.
Route::get('/verifikasi', function () {
    return view('user.verifikasi');
});

// Route untuk memproses permintaan tambah verifikasi sebagai pengajuan verifikasi akun pengguna.
Route::post('/PostVerifikasi', 'App\Http\Controllers\VerifikasiController@PostVerifikasi');

/**
 *
 */


/**
 * Fitur Kelola Akun Pengguna dan Verifikasi Akun Pengguna oleh Admin.
 */

// Route untuk menampilkan halaman daftar seluruh pengguna serta pengajuan verifikasi akun pengguna.
Route::get('/user', 'App\Http\Controllers\VerifikasiController@VerifikasiUser');

// Route untuk memproses permintaan untuk memverifikasi akun pengguna.
Route::get('/user/{verify_id}', 'App\Http\Controllers\VerifikasiController@VerifyUser');

/**
 *
 */


/**
 * Fitur Kelola Rekening untuk Toko yang didaftarkan oleh pengguna.
 * Jika masuk sebagai admin maka akan ditandai sebagai Admin dan dapat memasuki " Route untuk menampilkan halaman daftar rekening ".
 * Jika melewati " Route untuk masuk ke sistem sebagai Toko " maka akan ditandai sebagai Toko.
 */

// Route untuk menampilkan halaman tambah rekening
Route::get('/rekening', 'App\Http\Controllers\RekeningController@rekening');

// Route untuk memproses permintaan tambah rekening.
Route::post('/PostRekening', 'App\Http\Controllers\RekeningController@PostRekening');

// Route untuk menampilkan halaman daftar rekening.
// * Admin dapat melihat seluruh daftar rekening setiap toko
// * Toko hanya dapat melihat daftar rekening yang ditambahkan oleh toko tersebut.
Route::get('/daftar_rekening', 'App\Http\Controllers\RekeningController@daftar_rekening');

Route::get('/produk', 'App\Http\Controllers\ProdukController@produk');
Route::get('/produksupplier', 'App\Http\Controllers\ProdukSupplierController@produksupplier');
Route::get('/jasa_kreatif', 'App\Http\Controllers\ProdukController@jasa_kreatif');
Route::post('/cari', 'App\Http\Controllers\ProdukController@cari');
Route::post('/cari_produksupplier', 'App\Http\Controllers\ProdukSupplierController@cari_produksupplier');
Route::get('/cari/{cari}', 'App\Http\Controllers\ProdukController@cari_view');
Route::get('/cari_produksupplier/{cari}', 'App\Http\Controllers\ProdukSupplierController@cari_view_produk_supplier');
Route::get('/lihat_produk/{product_id}', 'App\Http\Controllers\ProdukController@lihat_produk');
Route::get('/lihat_produk_supplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@lihat_produk_supplier');
Route::get('/lihat_jasa_kreatif/{service_id}', 'App\Http\Controllers\ProdukController@lihat_jasa_kreatif');
Route::get('/produk/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukController@produk_kategori');
Route::get('/produk_supplier/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_kategori');
Route::get('/produk/kategori/sub_kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukController@jasa_kreatif_kategori');
Route::get('/produk/toko[{merchant_id}]', 'App\Http\Controllers\ProdukController@produk_toko_belanja');
Route::get('/produk_supplier/toko[{merchant_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_toko_belanja');

Route::get('/tambah_produk/pilih_kategori', 'App\Http\Controllers\ProdukController@pilih_kategori');
Route::get('/tambah_produk_supplier/pilih_kategori', 'App\Http\Controllers\ProdukSupplierController@pilih_kategori_produk_supplier');
// Route::get('/tambah_produk/pilih_jasa_kreatif', 'App\Http\Controllers\ProdukController@pilih_jasa_kreatif');
Route::get('/tambah_produk/{kategori_produk_id}', 'App\Http\Controllers\ProdukController@tambah_produk');
Route::get('/tambah_produk_supplier/{kategori_produk_id}', 'App\Http\Controllers\ProdukSupplierController@tambah_produk_supplier');
Route::get('/tambah_jasa_kreatif', 'App\Http\Controllers\ProdukController@tambah_jasa_kreatif');
Route::post('/PostTambahProduk/{kategori_produk_id}', 'App\Http\Controllers\ProdukController@PostTambahProduk');
Route::post('/PostTambahProdukSupplier/{kategori_produk_id}', 'App\Http\Controllers\ProdukSupplierController@PostTambahProdukSupplier');
Route::post('/PostTambahJasaKreatif', 'App\Http\Controllers\ProdukController@PostTambahJasaKreatif');
Route::get('/edit_produk/{product_id}', 'App\Http\Controllers\ProdukController@edit_produk');
Route::get('/edit_produk_supplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@edit_produk_supplier');
Route::get('/edit_jasa_kreatif/{service_id}', 'App\Http\Controllers\ProdukController@edit_jasa_kreatif');
Route::post('/PostEditProduk/{product_id}', 'App\Http\Controllers\ProdukController@PostEditProduk');
Route::post('/PostEditProdukSupplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@PostEditProdukSupplier');
Route::post('/PostEditJasaKreatif/{service_id}', 'App\Http\Controllers\ProdukController@PostEditJasaKreatif');
// Route untuk memproses permintaan hapus rekening untuk toko.
Route::get('/hapus_rekening/{rekening_id}', 'App\Http\Controllers\RekeningController@HapusRekening');

/**
 *
 */


/**
 * Fitur Autentikasi Toko.
 */

// Route untuk masuk ke sistem sebagai Toko
Route::post('/MasukToko', 'App\Http\Controllers\TokoController@MasukToko');

// Route untuk keluar dari toko pada sistem.
Route::get('/keluar_toko', 'App\Http\Controllers\TokoController@keluar_toko');

// Route untuk mendaftarkan toko baru.
Route::post('/PostTambahToko', 'App\Http\Controllers\TokoController@PostTambahToko');

/**
 *
 */


/**
 * Fitur Kelola Informasi Data pada Toko.
 * Hanya dapat diakses jika melewati " Route untuk masuk ke sistem sebagai Toko ".
 */

// Route untuk halaman toko yang menampilkan informasi data tentang Toko.
Route::get('/toko', 'App\Http\Controllers\TokoController@toko');

// Route untuk halaman edit informasi data toko.
Route::get('/edit_toko', 'App\Http\Controllers\TokoController@edit_toko');

// Route untuk memproses permintaan edit informasi data toko.
Route::post('/PostEditToko', 'App\Http\Controllers\TokoController@PostEditToko');

// Route untuk memproses permintaan libur atau buka toko.
Route::get('/libur_toko', 'App\Http\Controllers\TokoController@LiburToko');

/**
 *
 */


/**
 * Fitur Kelola Toko Verifikasi Toko oleh Admin.
 */

// Route untuk menampilkan halaman daftar seluruh toko serta pengajuan verifikasi toko.
Route::get('/toko_user', 'App\Http\Controllers\TokoController@TokoUser');

// Route untuk memproses permintaan untuk memverifikasi toko.
Route::get('/verify_toko/{merchant_id}', 'App\Http\Controllers\TokoController@VerifyToko');

// Route untuk memunculkan modal tutup toko.
Route::get('/close_merchant_modal/{merchant_id}', 'App\Http\Controllers\TokoController@close_merchant_modal');

// Route untuk menutup toko.
Route::get('/tutup_toko/{merchant_id}', 'App\Http\Controllers\TokoController@tutup_toko');


/**
 *
 */


/**
 * Fitur Kelola Tipe Spesifikasi oleh Admin.
 * Contoh: Warna.
 */


// Route untuk menampilkan halaman daftar seluruh tipe spesifikasi yang ditambahkan.
Route::get('/tipe_spesifikasi', 'App\Http\Controllers\SpesifikasiController@tipe_spesifikasi');

// Route untuk memproses permintaan tambah tipe spesifikasi.
Route::post('/PostTambahTipeSpesifikasi', 'App\Http\Controllers\SpesifikasiController@PostTambahTipeSpesifikasi');

// Route untuk memproses permintaan edit tipe spesifikasi.
Route::post('/PostEditTipeSpesifikasi/{specification_type_id}', 'App\Http\Controllers\SpesifikasiController@PostEditTipeSpesifikasi');

/**
 *
 */


/**
 * Fitur Kelola Spesifikasi oleh Admin.
 * Spesifikasi ditambahkan berdasarkan Tipe Spesifikasi yang ditargetkan
 * Contoh: Biru, Tipe Spesifikasinya adalah Warna
 */

// Route untuk menampilkan halaman daftar seluruh spesifikasi yang ditambahkan.
Route::get('/spesifikasi', 'App\Http\Controllers\SpesifikasiController@spesifikasi');

// Route untuk memproses permintaan tambah spesifikasi.
Route::post('/PostTambahSpesifikasi', 'App\Http\Controllers\SpesifikasiController@PostTambahSpesifikasi');

// Route untuk memproses permintaan edit spesifikasi.
Route::post('/PostEditSpesifikasi/{specification_id}', 'App\Http\Controllers\SpesifikasiController@PostEditSpesifikasi');

/**
 *
 */


/**
 * Fitur Kelola Kategori Produk oleh Admin.
 */

// Route untuk menampilkan halaman daftar seluruh kategori yang ditambahkan.
Route::get('/kategori_produk', 'App\Http\Controllers\KategoriController@kategori_produk');
Route::get('/kategori_produk_supplier', 'App\Http\Controllers\KategoriProdukSupplierController@kategori_produk_supplier');
Route::get('/sub_kategori', 'App\Http\Controllers\SubCategoryController@index');

// Route untuk memproses permintaan tambah kategori.
Route::post('/PostTambahKategoriProduk', 'App\Http\Controllers\KategoriController@PostTambahKategoriProduk');
Route::post('/PostTambahKategoriProdukSupplier', 'App\Http\Controllers\KategoriProdukSupplierController@PostTambahKategoriProdukSupplier');
Route::post('/PostTambahSubKategoriProduk', 'App\Http\Controllers\SubCategoryController@store');

// Route untuk memproses permintaan edit kategori.
Route::post('/PostEditKategoriProduk/{kategori_produk_id}', 'App\Http\Controllers\KategoriController@PostEditKategoriProduk');
Route::post('/PostEditKategoriProdukSupplier/{kategori_produk_id}', 'App\Http\Controllers\KategoriProdukSupplierController@PostEditKategoriProdukSupplier');
// Route::get('/hapus_kategori_produk/{kategori_produk_id}', 'App\Http\Controllers\KategoriController@HapusKategoriProduk');
Route::post('/PostEditSubKategoriProduk/{sub_kategori_produk_id}', 'App\Http\Controllers\SubCategoryController@update');

Route::get('/kategori_produk_supplier', 'App\Http\Controllers\KategoriProdukSupplierController@kategori_produk_supplier');
Route::post('/TambahKategoriProdukSupplier', 'App\Http\Controllers\KategoriProdukSupplierController@TambahKategoriProdukSupplier');
Route::post('/EditKategoriProdukSupplier/{kategori_produk_supplier_id}', 'App\Http\Controllers\KategoriProdukSupplierController@EditKategoriProdukSupplier');
// Route::get('/hapus_kategori_produk_supplier/{kategori_produk_supplier_id}', 'App\Http\Controllers\KategoriProdukSupplierController@HapusKategoriProdukSupplier');

// Route untuk menampilkan halaman daftar seluruh kategori tipe spesifikasi yang ditambahkan.
Route::get('/kategori_tipe_spesifikasi', 'App\Http\Controllers\KategoriController@kategori_tipe_spesifikasi');
Route::get('/kategori_tipe_spesifikasi_produk_supplier', 'App\Http\Controllers\KategoriProdukSupplierController@kategori_tipe_spesifikasi_produk_supplier');

// Route untuk memproses permintaan tambah kategori tipe spesifikasi.
Route::post('/PostTambahKategoriTipeSpesifikasi', 'App\Http\Controllers\KategoriController@PostTambahKategoriTipeSpesifikasi');
Route::post('/PostTambahKategoriTipeSpesifikasiProdukSupplier', 'App\Http\Controllers\KategoriProdukSupplierController@PostTambahKategoriTipeSpesifikasiProdukSupplier');

// Route untuk memproses permintaan edit kategori tipe spesifikasi.
Route::post('/PostEditKategoriTipeSpesifikasi/{category_type_specification_id}', 'App\Http\Controllers\KategoriController@PostEditKategoriTipeSpesifikasi');
Route::post('/PostEditKategoriTipeSpesifikasiProdukSupplier/{category_type_specification_id}', 'App\Http\Controllers\KategoriProdukSupplierController@PostEditKategoriTipeSpesifikasiProdukSupplier');

/**
 *
 */


/**
 * Fitur Kelola Produk oleh Toko.
 */

// Route untuk menampilkan halaman daftar kategori yang dapat dipilih untuk dapat menambahkan produk
Route::get('/tambah_produk/pilih_kategori', 'App\Http\Controllers\KategoriController@pilih_kategori');

Route::get('/rekening', 'App\Http\Controllers\RekeningController@rekening');
Route::post('/PostRekening', 'App\Http\Controllers\RekeningController@PostRekening');
Route::get('/daftar_rekening', 'App\Http\Controllers\RekeningController@daftar_rekening');
Route::get('/hapus_rekening/{bank_id}', 'App\Http\Controllers\RekeningController@HapusRekening');

Route::get('/produk', 'App\Http\Controllers\ProdukController@produk');
Route::get('/produksupplier', 'App\Http\Controllers\ProdukSupplierController@produksupplier');
Route::post('/cari', 'App\Http\Controllers\ProdukController@cari');
Route::post('/cari_produksupplier', 'App\Http\Controllers\ProdukSupplierController@cari_produksupplier');
Route::get('/cari/{cari}', 'App\Http\Controllers\ProdukController@cari_view');
Route::get('/cari_produksupplier/{cari}', 'App\Http\Controllers\ProdukSupplierController@cari_view_produk_supplier');
Route::get('/lihat_produk/{product_id}', 'App\Http\Controllers\ProdukController@lihat_produk');
Route::get('/lihat_produk_supplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@lihat_produk_supplier');
Route::get('/produk/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukController@produk_kategori');
Route::get('/produk_supplier/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_kategori');
Route::get('/produk/toko[{merchant_id}]', 'App\Http\Controllers\ProdukController@produk_toko_belanja');
Route::get('/produk_supplier/toko[{merchant_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_toko_belanja');

Route::get('/tambah_produk/pilih_kategori', 'App\Http\Controllers\ProdukController@pilih_kategori');
Route::get('/tambah_produk_supplier/pilih_kategori', 'App\Http\Controllers\ProdukSupplierController@pilih_kategori_produk_supplier');
Route::get('/tambah_produk/{kategori_produk_id}', 'App\Http\Controllers\ProdukController@tambah_produk');
Route::get('/tambah_produk_supplier/{kategori_produk_id}', 'App\Http\Controllers\ProdukSupplierController@tambah_produk_supplier');
// Route untuk menampilkan halaman form tambah produk.
Route::get('/tambah_produk', 'App\Http\Controllers\ProdukController@tambah_produk');

// Route untuk memproses permintaan tambah produk.
Route::post('/PostTambahProduk/{kategori_produk_id}', 'App\Http\Controllers\ProdukController@PostTambahProduk');
Route::post('/PostTambahProdukSupplier/{kategori_produk_id}', 'App\Http\Controllers\ProdukSupplierController@PostTambahProdukSupplier');
Route::post('/PostTambahProduk', 'App\Http\Controllers\ProdukController@PostTambahProduk');

// Route untuk menampilkan halaman edit produk.
Route::get('/edit_produk/{product_id}', 'App\Http\Controllers\ProdukController@edit_produk');
Route::get('/edit_produk_supplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@edit_produk_supplier');

// Route untuk memproses permintaan edit produk.
Route::post('/PostEditProduk/{product_id}', 'App\Http\Controllers\ProdukController@PostEditProduk');
Route::post('/PostEditProdukSupplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@PostEditProdukSupplier');

// Route untuk memproses permintaan hapus produk.
Route::get('/HapusProduk/{product_id}', 'App\Http\Controllers\ProdukController@HapusProduk');
Route::get('/HapusProdukSupplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@HapusProdukSupplier');
Route::get('/HapusJasaKreatif/{service_id}', 'App\Http\Controllers\ProdukController@HapusJasaKreatif');

/**
 *
 */


// Route untuk menampilkan halaman daftar seluruh produk dari setiap toko pada admin.
Route::get('/produk_toko', 'App\Http\Controllers\ProdukController@produk_toko');
Route::get('/produksupplier_toko', 'App\Http\Controllers\ProdukSupplierController@produksupplier_toko');


/**
 * Fitur Eksplorasi Produk yang ditambahkan oleh penjual.
 * Jika melewati " Route untuk masuk ke sistem sebagai Toko " maka akan ditandai sebagai Toko.
 * Toko hanya dapat melihat daftar dan detail produk yang mereka tambahkan.
 * Pengguna serta pengunjung dapat melihat daftar dan detail seluruh produk yang ditambahkan oleh toko.
 */

// Route untuk menampilkan halaman daftar seluruh produk.
Route::get('/produk', 'App\Http\Controllers\ProdukController@produk');
Route::get('/produksupplier', 'App\Http\Controllers\ProdukSupplierController@produksupplier');

// Route untuk menampilkan lebih banyak produk.
// Route::get('/produk_more', 'App\Http\Controllers\ProdukController@produk');

// Route untuk memproses permintaan mencari produk.
Route::post('/cari', 'App\Http\Controllers\ProdukController@cari');
Route::post('/cari_produksupplier', 'App\Http\Controllers\ProdukSupplierController@cari_produksupplier');

// Route untuk menampilkan halaman daftar produk yang dicari.
Route::get('/cari/{cari}', 'App\Http\Controllers\ProdukController@cari_view');
Route::get('/cari_produksupplier/{cari}', 'App\Http\Controllers\ProdukSupplierController@cari_view_produk_supplier');

// Route untuk menampilkan halaman lihat produk yang akan menampilkan detail dari produk.
Route::get('/lihat_produk/{product_id}', 'App\Http\Controllers\ProdukController@lihat_produk');
Route::get('/lihat_produk_supplier/{product_id}', 'App\Http\Controllers\ProdukSupplierController@lihat_produk_supplier');

// Route untuk menampilkan halaman daftar produk yang akan menampilkan produk berdasarkan kategorinya.
Route::get('/produk/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukController@produk_kategori');
Route::get('/produk_supplier/kategori[{kategori_produk_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_kategori');

// Route untuk menampilkan halaman daftar produk yang akan menampilkan produk berdasarkan tokonya.
Route::get('/produk/toko[{merchant_id}]', 'App\Http\Controllers\ProdukController@produk_toko_belanja');
Route::get('/produk_supplier/toko[{merchant_id}]', 'App\Http\Controllers\ProdukSupplierController@produk_supplier_toko_belanja');

/**
 *
 */


/**
 * Fitur Kelola Bank oleh Admin.
 * Ini butuhkan agar toko yang ingin mendaftar dapat menambahkan nomor rekening mereka berdasarkan bank yang disediakan.
 */

// Route untuk menampilkan halaman daftar seluruh bank yang ditambahkan.
Route::get('/bank', 'App\Http\Controllers\BankController@bank');

// Route untuk memproses permintaan tambah bank spesifikasi.
Route::post('/PostTambahBank', 'App\Http\Controllers\BankController@PostTambahBank');

// Route untuk memproses permintaan edit bank spesifikasi.
Route::post('/PostEditBank/{bank_id}', 'App\Http\Controllers\BankController@PostEditBank');

// Route untuk memproses permintaan hapus bank spesifikasi.
Route::get('/hapus_bank/{bank_id}', 'App\Http\Controllers\BankController@HapusBank');

/**
 *
 */


/**
 * Fitur Kelola Daftar Keinginan oleh Pembeli.
 */

// Route untuk menampilkan halaman daftar keinginan yang dimana akan menampilkan produk yang dimasukkan ke dalam daftar keinginan.
Route::get('/daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@daftar_keinginan');

// Route untuk memproses permintaan tambah produk ke daftar keinginan melalui AJAX yang terdapat pada file function_2.js untuk " #tambah_produk_keinginan ".
Route::get('/masuk_daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@masuk_daftar_keinginan');

// Route untuk memproses permintaan hapus produk dari daftar keinginan melalui AJAX yang terdapat pada file function_2.js untuk " #hapus_produk_keinginan ".
Route::get('/hapus_daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@hapus_daftar_keinginan');

// Route untuk memproses permintaan hapus produk dari daftar keinginan pada halaman Daftar Keinginan.
Route::get('/hapus_daftar_keinginan/{id}', 'App\Http\Controllers\DaftarKeinginanController@hapus_produk_pada_daftar_keinginan');

/**
 *
 */


/**
 * Fitur Kelola Keranjang oleh Pembeli.
 */

// Route untuk menampilkan halaman keranjang yang dimana akan menampilkan produk yang dimasukkan ke dalam keranjang.
Route::get('/keranjang', 'App\Http\Controllers\KeranjangController@keranjang');

// Route untuk memproses permintaan tambah produk ke keranjang melalui AJAX yang terdapat pada file function_2.js untuk " #tambah_produk_keranjang ".
Route::get('/masuk_keranjang', 'App\Http\Controllers\KeranjangController@masuk_keranjang');

// Route untuk memproses permintaan tambah produk ke keranjang berdasarkan jumlah yang dimasukkan pada inputan untuk tombol " BELI SEKARANG ".
Route::post('/masuk_keranjang_beli/{product_id}', 'App\Http\Controllers\KeranjangController@masuk_keranjang_beli');

// Route untuk memproses permintaan hapus produk dari keranjang.
Route::get('/hapus_keranjang/{cart_id}', 'App\Http\Controllers\KeranjangController@HapusKeranjang');

/**
 *
 */


/**
 * Fitur Dalam Proses Pembelian .
 * Kelola dan Pemantauan pada Pembelian
 */

// Route untuk menampilkan halaman checkout serta memproses permintaan untuk perbarui jumlah produk yang ada dalam keranjang berdasarkan tokonya.
Route::post('/checkout/{merchant_id}', 'App\Http\Controllers\PembelianController@checkout');
Route::post('/checkout_jasa/{merchant_id}', 'App\Http\Controllers\PembelianController@checkout_jasa');

Route::get('/pilih_metode_pembelian', 'App\Http\Controllers\PembelianController@pilih_metode_pembelian');

Route::get('/ambil_jalan', 'App\Http\Controllers\PembelianController@ambil_jalan');

Route::post('/cek_ongkir', 'App\Http\Controllers\PembelianController@cek_ongkir');

Route::get('/voucher', 'App\Http\Controllers\VoucherController@voucher');
Route::get('/pilih_tipe_voucher', 'App\Http\Controllers\VoucherController@pilih_tipe_voucher');
// Route::get('/pilih_target_kategori_voucher', 'App\Http\Controllers\VoucherController@pilih_target_kategori_voucher');
Route::post('/PostTambahVoucher', 'App\Http\Controllers\VoucherController@PostTambahVoucher');
Route::get('/hapus_voucher/{voucher_id}', 'App\Http\Controllers\VoucherController@HapusVoucher');

Route::get('/ambil_voucher_pembelian', 'App\Http\Controllers\PembelianController@ambil_voucher_pembelian');

// Route untuk mengambil voucher ongkos kirim melalui AJAX yang terdapat pada file function.js untuk " #voucher_pembelian ".
Route::get('/ambil_voucher_ongkos_kirim', 'App\Http\Controllers\PembelianController@ambil_voucher_ongkos_kirim');

// Route untuk memproses permintaan tambah pembelian yang dilakukan.
Route::post('/PostBeliProduk', 'App\Http\Controllers\PembelianController@PostBeliProduk');
Route::post('/PostBeliJasa', 'App\Http\Controllers\PembelianController@PostBeliJasa');


// Route untuk menampilkan total pembelian dengan memilih tanggal awal dan akhirnya
// Hanya dapat digunakan jika masuk sebagai admin.
Route::get('/jumlah_pembelian', 'App\Http\Controllers\PembelianController@jumlah_pembelian');


// Route untuk menampilkan halaman daftar pembelian yang ada.
// Jika masuk sebagai Pengguna maka akan menampilkan daftar dari pembelian yang telah dilakukan.
// Jika memasuki Toko maka akan menampilkan daftar pembelian dari toko tersebut.
// Jika masuk sebagai Admin maka akan menampilkan daftar seluruh pembelian.
Route::get('/daftar_pembelian', 'App\Http\Controllers\PembelianController@daftar_pembelian');

// Jika masuk sebagai Admin maka akan menampilkan daftar seluruh pemesanan experience.
Route::get('/daftar_pemesanan', 'App\Http\Controllers\PembelianController@daftar_pemesan');
Route::get('/daftar_pemesanan-rental', 'App\Http\Controllers\PembelianController@daftar_pemesanan_rental');

// Route untuk menampilkan halaman detail dari pembelian.
Route::get('/detail_pembelian/{purchase_id}', 'App\Http\Controllers\PembelianController@detail_pembelian');
Route::get('/detail_pembelian_jasa/{service_id}', 'App\Http\Controllers\PembelianController@detail_pembelian_jasa');

// Route untuk menyetujui ataupun tolak jasa
Route::get('/setuju_jasa/{service_booking_id}', 'App\Http\Controllers\PembelianController@setuju_jasa');
Route::get('/tolak_jasa/{service_booking_id}', 'App\Http\Controllers\PembelianController@tolak_jasa');

// Route untuk terima ataupun tolak pembayaran jasa
Route::get('/terima_pembayaran_jasa/{service_purchase_id}/{service_booking_id}', 'App\Http\Controllers\PembelianController@terima_pembayaran_jasa');
Route::get('/tolak_pembayaran_jasa/{service_purchase_id}', 'App\Http\Controllers\PembelianController@tolak_pembayaran_jasa');

// Route untuk konfirmasi selesai pesanan
Route::get('/konfirmasi_pesanan_selesai/{service_booking_id}', 'App\Http\Controllers\PembelianController@konfirmasi_pesanan_selesai');

// Route untuk menampilkan detail dari pembelian yang dilakukan oleh pembeli.
// Hanya dapat digunakan jika masuk sebagai admin.
Route::get("/purchase/detail/{id}", "App\Http\Controllers\PembelianController@detail_purchase");

// Route untuk memunculkan modal hapus pembelian.
// Hanya dapat digunakan jika masuk sebagai admin.
Route::get('/delete_purchase_modal/{purchase_id}', 'App\Http\Controllers\PembelianController@delete_purchase_modal');

// Route untuk menghapus pembelian.
// Hanya dapat digunakan jika masuk sebagai admin.
Route::get('/hapus_pembelian/{purchase_id}', 'App\Http\Controllers\PembelianController@hapus_pembelian');

// Route untuk memproses permintaan tambah bukti pembayaran.
Route::post('/PostBuktiPembayaran/{purchase_id}', 'App\Http\Controllers\PembelianController@PostBuktiPembayaran');

// Route untuk memproses permintaan batalkan pesanan oleh pembeli.
Route::get('/batalkan_pembelian/{purchase_id}', 'App\Http\Controllers\PembelianController@batalkan_pembelian');
// Route untuk menampilkan halaman lihat produk yang akan menampilkan detail dari produk.
Route::get('/lihat_produk/{product_id}', 'App\Http\Controllers\ProdukController@lihat_produk');

Route::get('/invoice_pembelian/{purchase_id}', 'App\Http\Controllers\InvoiceController@invoice_pembelian');
Route::get('/invoice_penjualan/{purchase_id}', 'App\Http\Controllers\InvoiceController@invoice_penjualan');

Route::post('/PostBuktiPembayaran/{purchase_id}', 'App\Http\Controllers\PembelianController@PostBuktiPembayaran');
// upload bukti pembayaran + add service purchase
Route::post('/PostBuktiPembayaranJasa/{id}', 'App\Http\Controllers\PembelianController@PostBuktiPembayaranJasa');
Route::get('/update_status_pembelian/{purchase_id}', 'App\Http\Controllers\PembelianController@update_status_pembelian');

// Route untuk memproses permintaan perbarui status pesanan dan nomor resi pesanan.
Route::post('/update_status2_pembelian/{purchase_id}', 'App\Http\Controllers\PembelianController@update_status2_pembelian');

// Route untuk memproses permintaan perbarui nomor resi pesanan.
Route::post('/update_no_resi/{purchase_id}', 'App\Http\Controllers\PembelianController@update_no_resi');

Route::get('/keranjang', 'App\Http\Controllers\KeranjangController@keranjang');
// Route::get('/masuk_keranjang/{product_id}', 'App\Http\Controllers\KeranjangController@masuk_keranjang');
Route::get('/masuk_keranjang', 'App\Http\Controllers\KeranjangController@masuk_keranjang');
Route::post('/masuk_keranjang_beli/{product_id}', 'App\Http\Controllers\KeranjangController@masuk_keranjang_beli');
Route::post('/masuk_keranjang_beli_jasa/{service_id}', 'App\Http\Controllers\KeranjangController@masuk_keranjang_beli_jasa');
Route::get('/hapus_keranjang/{cart_id}', 'App\Http\Controllers\KeranjangController@HapusKeranjang');

Route::get('/daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@daftar_keinginan');
Route::get('/masuk_daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@masuk_daftar_keinginan');
Route::get('/hapus_daftar_keinginan', 'App\Http\Controllers\DaftarKeinginanController@hapus_daftar_keinginan');
Route::get('/hapus_daftar_keinginan/{id}', 'App\Http\Controllers\DaftarKeinginanController@hapus_produk_pada_daftar_keinginan');

Route::get('/carousel', 'App\Http\Controllers\CarouselController@carousel');

// Route untuk memproses permintaan tambah carousel.
Route::post('/PostTambahCarousel', 'App\Http\Controllers\CarouselController@PostTambahCarousel');

// Route untuk memproses permintaan edit carousel.
Route::post('/PostEditCarousel/{id}', 'App\Http\Controllers\CarouselController@PostEditCarousel');

// Route untuk memproses permintaan hapus carousel.
Route::get('/hapus_carousel/{id}', 'App\Http\Controllers\CarouselController@HapusCarousel');

// Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse.index');
// Route::get('/warehouse/add', [WarehouseController::class, 'create'])->name('warehouse.create');
Route::get('/warehouse/api', [WarehouseController::class, 'warehouseListAPI']);
Route::resource('warehouse', WarehouseController::class);
Route::get('/gallery/warehouse/api', [GalleryController::class, 'warehouseListAPI']);
Route::resource('gallery', GalleryController::class);
Route::put('/admin/accept/warehouse/{id}', [AdminRequestWarehouseController::class, 'update'])->name('admin.accept.warehouse.update');

Route::get('/admin/warehouse', [DashboardController::class, 'index'])->name('admin.warehouse.index');;

Route::get('/admin/produkwarehouse', [ProdukWarehouseController::class, 'produkwarehouse'])->name('admin.produk.warehouse');
Route::get('/admin/pembelianproduk', [ProdukWarehouseController::class, 'pembelianproduk'])->name('admin.pembelianproduk.warehouse');
Route::get('/admin/TambahProdukWarehouse', [ProdukWarehouseController::class, 'tambahproduk'])->name('admin.tambahproduk.warehouse');
Route::post('/addStock', [ProdukWarehouseController::class, 'addStock'])->name('admin.addStock.warehouse');
Route::get('/admin/produkwarehouse/{id}/edit', [ProdukWarehouseController::class, 'editProduk'])->name('admin.editProduk.warehouse');
Route::get('/admin/produkwarehouse/{id}/hapus', [ProdukWarehouseController::class, 'hapusProduk'])->name('admin.hapusProduk.warehouse');
Route::put('/admin/produkWarehouse/{id}/update', [ProdukWarehouseController::class, 'updateProduk'])->name('admin.updateProduk.warehouse');


Route::get('/admin/transaksiwarehouse', [TransaksiWarehouseController::class, 'transaksiwarehouse'])->name('admin.transaksiwarehouse.warehouse');
Route::get('/admin/TambahTransaksiWarehouse', [TransaksiWarehouseController::class, 'tambahtransaksi'])->name('admin.tambahtransaksi.warehouse');
Route::post('/addTransaksi', [TransaksiWarehouseController::class, 'addTransaksi'])->name('admin.addTransaksi.warehouse');
Route::get('/admin/TambahTransaksiWarehouse/{id}/hapus', [TransaksiWarehouseController::class, 'deleteTransaksi'])->name('admin.deleteTransaksi.warehouse');
Route::get('/admin/transaksiWarehouse/{id}/edit', [TransaksiWarehouseController::class, 'editTransaksi'])->name('admin.editTransaksi.warehouse');
Route::put('/admin/transaksiWarehouse/{id}/update', [TransaksiWarehouseController::class, 'updateTransaksi'])->name('admin.updateTransaksi.warehouse');

Route::get('/admin/stokopname', [TransaksiWarehouseController::class, 'stokOpname'])->name('admin.stokopname.warehouse');
Route::get('/admin/Tambahstokopname', [TransaksiWarehouseController::class, 'TambahstokOpname'])->name('admin.Tambahstokopname.warehouse');
Route::post('/addStockOpname', [TransaksiWarehouseController::class, 'addStockOpname'])->name('admin.addStockOpname.warehouse');
Route::get('/admin/addStokOpname/{id}/edit', [TransaksiWarehouseController::class, 'editStokOpname'])->name('admin.editStokOpname.warehouse');
Route::post('/admin/addStokOpname/{id}/update', [TransaksiWarehouseController::class, 'updateStokOpname'])->name('admin.updateStokOpname.warehouse');
Route::get('/admin/deleteStokOpname/{id}/hapus', [TransaksiWarehouseController::class, 'deleteStokOpname'])->name('admin.deleteStokOpname.warehouse');

Route::get('/admin/laporanpemesanan', [LaporanWarehouseController::class, 'laporanpemesanan'])->name('admin.laporanpemesanan.warehouse');
Route::get('/admin/laporanstok', [LaporanWarehouseController::class, 'laporanstok'])->name('admin.laporanstok.warehouse');
Route::get('/admin/laporanpemesanan/date', [LaporanWarehouseController::class, 'searchByDate'])->name('admin.searchByDate.warehouse');

Route::get('/admin/notifikasiwarehouse', [NotifikasiWarehouseController::class, 'getNotifications'])->name('admin.notifikasiwarehouse.warehouse');
Route::get('/admin/notifikasi', [NotifikasiWarehouseController::class, 'getNotificationsCount'])->name('admin.getNotificationsCount.warehouse');

Route::get('/admin/request/warehouse', [AdminRequestWarehouseController::class, 'index'])->name('admin.request.warehouse.index');
Route::get('/admin/request/warehouse/{id}', [AdminRequestWarehouseController::class, 'show'])->name('admin.request.warehouse.show');

Route::get("/admin/chatbot/model", [ChatbotController::class, 'model']);
Route::get("/admin/chatbot/dataset", [ChatbotController::class, 'dataset']);
Route::get("/admin/chatbot/add-dataset", [ChatbotController::class, 'addDataset']);
Route::post("/admin/chatbot/add-dataset", [ChatbotController::class, 'postAddDataset']);

Route::post('/admin/request/gallery', [AdminRequestGalleryController::class, 'store'])->name('admin.request.gallery.store');
Route::get('/admin/gallery/checkout', [AdminGalleryController::class, 'checkout'])->name('admin.gallery.checkout');
Route::get('/admin/gallery/soldout', [AdminGalleryController::class, 'soldout'])->name('admin.gallery.soldout');
Route::get('/admin/gallery/history', [AdminGalleryController::class, 'history'])->name('admin.gallery.history');
Route::get('/admin/gallery/history/{id}', [AdminGalleryController::class, 'historyDetail'])->name('admin.gallery.history.detail');
Route::get('/admin/gallery', [AdminGalleryController::class, 'index'])->name('admin.gallery.index');
Route::put('/admin/accept/gallery/{id}', [AdminRequestGalleryController::class, 'update'])->name('admin.accept.gallery.update');
Route::get('/admin/request/galley', [AdminRequestGalleryController::class, 'index'])->name('admin.request.gallery.index');
Route::get('/admin/request/gallery/{id}', [AdminRequestGalleryController::class, 'show'])->name('admin.request.gallery.show');


Route::post('/PostTinjauan/{product_id}', 'App\Http\Controllers\TinjauanController@PostTinjauan');


// Route untuk menampilkan halaman panduan penggunaan.
Route::get('/panduan_penggunaan', function () {
    return view('user.panduan_penggunaan');
});

// EXPERIENCE
Route::get('/experience', [ExperienceController::class, 'index'])->name('experience.index');
Route::get('/tiket', 'App\Http\Controllers\TiketController@landing_tiketmuseum')->name('tiket.index');
Route::get('/detailtiket', 'App\Http\Controllers\TiketController@detailtiket');
Route::get('/pembayaran', 'App\Http\Controllers\TiketController@pembayaran');
Route::get('/tiket/admin', [TiketController::class, 'indexAdmin'])->name('tiket.indexAdmin');

Route::get('/rental/mobil', [ExperienceController::class, 'rental_index'])->name('rental.index');
Route::get('/rental', [ExperienceController::class, 'rental']);
Route::get('/rental/list_mobil', [ExperienceController::class, 'view_list_mobil']);
Route::get('/rental/add', [ExperienceController::class, 'add'])->name('rental.add');
Route::get('/tiket/add', [TiketExperienceController::class, 'add'])->name('tiket.add');
Route::post('tiket/add/store', [TiketExperienceController::class, 'store'])->name('create_tiket');
Route::get(('/tiket/{id}/edit'), [TiketExperienceController::class, 'edit'])->name('tiket.edit');
Route::post(('/tiket/{id}/update'), [TiketExperienceController::class, 'update'])->name('tiket.update');
Route::get(('/tiket/{id}/detail'), [TiketExperienceController::class, 'detail'])->name('tiket.detail');
Route::get(('/tiket/{id}/delete'), [TiketExperienceController::class, 'delete'])->name('tiket.delete');

Route::get('/rental/{id}/edit', [ExperienceController::class, 'edit'])->name('rental.edit');
Route::get('/rental/{id}/detail', [ExperienceController::class, 'detail'])->name('rental.detail');
Route::put('/rental/{id}/update', [ExperienceController::class, 'update'])->name('rental.update');
Route::post('/rental/add', [MobilController::class, 'store'])->name('rental.store');
Route::get('/rental/{id}/delete', [ExperienceController::class, 'delete'])->name('rental.delete');
Route::get('/rental/pesanan', [ExperienceController::class, 'PesananRental'])->name('pesan_rental.index');
Route::get('/rental/pesanan/{id}', [ExperienceController::class, 'detailPesananRental'])->name('pesananRental.detail');
Route::get('/tiket/pesanan/{id}', [ExperienceController::class, 'detailPesananTiket'])->name('pesananTiket.detail');
Route::get('/daftar/sewa/rental', [ExperienceController::class, 'daftarSewaRental'])->name('rentalku');
Route::post('/rental/cari', [ExperienceController::class, 'cariRental'])->name('cari.rental');
Route::get('/tiket/pesanan', [ExperienceController::class, 'PesananTiket'])->name('pesan_tiket.index');

Route::get('/pesan_rental/{id}', [MobilController::class, 'pesanMobil'])->name('pesan_rental');
Route::get('/pesan_tiket/{id}', [TiketExperienceController::class, 'pesanTiket'])->name('pesan_tiket');
Route::post('/pesan_rental/{id}', [MobilController::class, 'pesanMobilStore'])->name('pesan_rental');
Route::post('/pesan_tiket/{id}', [TiketExperienceController::class, 'pesanTiketStore'])->name('pesan_tiket');

Route::get('/pembayaran/rental/{id}', [MobilController::class, 'pembayaranRental'])->name('pembayaran.rental');
Route::get('/cancel/rental/{id}', [MobilController::class, 'cancelRental'])->name('cancel.rental');
Route::post('checkout', [MobilController::class, 'proccess'])->name('checkout');
//Tiket
Route::get('/pembayaran/tiket/{id}', [TiketExperienceController::class, 'pembayaranTiket'])->name('pembayaran.tiket');
Route::post('checkouttiket', [TiketExperienceController::class, 'proccess'])->name('checkouttiket');
Route::get('canceltiket/{id}', [TiketExperienceController::class, 'delete'])->name('canceltiket');

/**
 * Fitur Chat untuk Penjual dan Pembeli.
 * Penjual hanya dapat mengobrol dengan Pembeli
 * Pembeli hanya dapat mengobrol dengan Penjual.
 */

// Route untuk menampilkan halaman daftar lawan mengobrol dari obrolan yang telah dilakukan.
Route::get('/chat', 'App\Http\Controllers\ObrolanController@chat');

// Route untuk menampilkan halaman seluruh isi obrolan yang telah dilakukan.
Route::get('/chat/{id}', 'App\Http\Controllers\ObrolanController@chatting');


Route::get('/real_time_chatting', 'App\Http\Controllers\ObrolanController@real_time_chatting');


// Route untuk memproses permintaan tambah chat untuk lawan mengobrol pada obrolan yang sedang dilakukan.
Route::post('/chat/{id}/PostChatting', 'App\Http\Controllers\ObrolanController@PostChatting');

// Route khusus untu kebutuhan khusus untuk dapat mengupdate alamat dengan menambahkan province_name, city_name, dan subdistrict_name
// Route::get('/alamat/update_alamat_pengguna/all', 'App\Http\Controllers\AlamatController@update_all_alamat_pengguna');
// Route::get('/alamat/update_alamat_toko/all', 'App\Http\Controllers\AlamatController@update_all_alamat_toko');


// Route untuk Privacy Policy, mengetahui informasi secara lengkap tentang aplikasi
Route::get('/privacy', 'App\Http\Controllers\PrivacyController@privacy');


// Route khusus untu kebutuhan khusus untuk hapus data dummy testing
Route::get('/testing/delete/delete_dummy', 'App\Http\Controllers\PembelianController@delete_dummy_testing');
Route::get('/bagikan', function () {
    return view('user.pembelian.share');
})->name('bagikan');

Route::get('password/reset', [AutentikasiController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('password/email', [AutentikasiController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AutentikasiController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('password/reset', [AutentikasiController::class, 'resetPassword'])->name('password.update');


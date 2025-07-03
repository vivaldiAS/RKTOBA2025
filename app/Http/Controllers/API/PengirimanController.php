<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Session;
use App\Notifications\ProductPurchasedNotification;


use Carbon\Carbon;

class PengirimanController extends Controller
{
public function postBeliProdukMultiProduk(Request $request)
{
    date_default_timezone_set('Asia/Jakarta');
    $user_id = Auth::id();

    $dataMerchants = $request->merchants;
    if (!$dataMerchants || !is_array($dataMerchants)) {
        return response()->json(['message' => 'Data merchants invalid'], 400);
    }

    DB::beginTransaction();
    try {
        $now = Carbon::now();

        // 1. Hitung total harga pembelian semua merchant
        $totalHargaPembelian = 0;
        $allCartIds = [];
        foreach ($dataMerchants as $merchantData) {
            $totalHargaPembelian += $merchantData['harga_pembelian'] ?? 0;
            $allCartIds = array_merge($allCartIds, $merchantData['cart_ids'] ?? []);
        }

        // 2. Insert 1 row ke purchases (untuk keseluruhan transaksi)
        $checkout_id = DB::table('checkouts')->insertGetId([
            'user_id' => $user_id,
            'catatan' => $request->catatan ?? '',
        ]);

        $purchase_id = DB::table('purchases')->insertGetId([
            'kode_pembelian' => 'rkt_' . time(),
            'user_id' => $user_id,
            'checkout_id' => $checkout_id,
            'alamat_purchase' => $request->alamat_purchase ?? '',
            'harga_pembelian' => $totalHargaPembelian,
            'potongan_pembelian' => $request->potongan_pembelian ?? 0,
            'status_pembelian' => $request->metode_pembelian == "ambil_ditempat" ? "status1_ambil" : "status1",
            'courier_code' => $request->courier_code ?? '',
            'service' => $request->service ?? '',
            'ongkir' => $request->ongkir ?? 0,
            'is_cancelled' => 0,
            'is_deleted' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Ambil semua produk dari semua cart_ids
        $products = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('carts.user_id', $user_id)
            ->whereIn('carts.cart_id', $allCartIds)
            ->select('carts.product_id', 'products.product_name', 'heavy', 'jumlah_masuk_keranjang', 'price', 'products.merchant_id')
            ->get();

        // 4. Insert product_purchases per produk
        foreach ($products as $product) {
            DB::table('product_purchases')->insert([
                'purchase_id' => $purchase_id,
                'product_id' => $product->product_id,
                'berat_pembelian_produk' => $product->jumlah_masuk_keranjang * $product->heavy,
                'jumlah_pembelian_produk' => $product->jumlah_masuk_keranjang,
                'harga_pembelian_produk' => $product->jumlah_masuk_keranjang * $product->price,
            ]);

            // Update stok
            DB::table('stocks')->where('product_id', $product->product_id)->decrement('stok', $product->jumlah_masuk_keranjang);

            // Hapus produk dari cart
            DB::table('carts')->where('user_id', $user_id)->where('product_id', $product->product_id)->delete();

            // Kirim notifikasi ke merchant (opsional)
            // ...
        }

        DB::commit();

        return response()->json([
            'message' => 'Checkout multi merchant berhasil',
            'purchase_id' => $purchase_id,
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'message' => 'Error saat proses checkout: ' . $e->getMessage(),
        ], 500);
    }
}

        public function PostBeliProduk(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $user_id = Auth::id();
        $kode_pembelian = 'rkt_' . time();
        $now = Carbon::now();

        // Ambil input dari request
        $catatan = $request->catatan;
        $merchant_id = $request->merchant_id;
        $voucher_pembelian = $request->voucher_pembelian;
        $voucher_ongkos_kirim = $request->voucher_ongkos_kirim;
        $metode_pembelian = $request->metode_pembelian;
        $harga_pembelian = $request->harga_pembelian;
        $potongan_pembelian = $request->potongan_pembelian;
        $alamat_purchase = $request->alamat_purchase;
        $courier_code = $request->courier;
        $service = $request->service;
        $ongkir = $request->ongkir ?? 0;

        // 1. Insert ke tabel checkouts
        $checkout_id = DB::table('checkouts')->insertGetId([
            'user_id' => $user_id,
            'catatan' => $catatan,
        ]);

        // 2. Insert ke claim_vouchers jika ada voucher
        if ($voucher_pembelian) {
            DB::table('claim_vouchers')->insert([
                'checkout_id' => $checkout_id,
                'voucher_id' => $voucher_pembelian,
            ]);
        }
        if ($voucher_ongkos_kirim) {
            DB::table('claim_vouchers')->insert([
                'checkout_id' => $checkout_id,
                'voucher_id' => $voucher_ongkos_kirim,
            ]);
        }

        // 3. Insert ke purchases
        $purchase_id = DB::table('purchases')->insertGetId([
            'kode_pembelian' => $kode_pembelian,
            'user_id' => $user_id,
            'checkout_id' => $checkout_id,
            'alamat_purchase' => $metode_pembelian == "ambil_ditempat" ? "" : $alamat_purchase,
            'harga_pembelian' => $harga_pembelian,
            'potongan_pembelian' => $potongan_pembelian,
            'status_pembelian' => $metode_pembelian == "ambil_ditempat" ? "status1_ambil" : "status1",
            'courier_code' => $courier_code,
            'service' => $service,
            'ongkir' => $metode_pembelian == "ambil_ditempat" ? 0 : $ongkir,
            'is_cancelled' => 0,
            'is_deleted' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Proses produk di keranjang
        $products = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->where('carts.user_id', $user_id)
            ->where('carts.merchant_id', $merchant_id)
            ->select('carts.product_id', 'products.name as product_name', 'heavy', 'jumlah_masuk_keranjang', 'price')
            ->get();

        foreach ($products as $product) {
            // Insert ke product_purchases
            DB::table('product_purchases')->insert([
                'purchase_id' => $purchase_id,
                'product_id' => $product->product_id,
                'berat_pembelian_produk' => $product->jumlah_masuk_keranjang * $product->heavy,
                'jumlah_pembelian_produk' => $product->jumlah_masuk_keranjang,
                'harga_pembelian_produk' => $product->jumlah_masuk_keranjang * $product->price,
            ]);

            // Update stok produk
            DB::table('stocks')->where('product_id', $product->product_id)->decrement('stok', $product->jumlah_masuk_keranjang);

            // Hapus dari cart
            DB::table('carts')->where('user_id', $user_id)->where('product_id', $product->product_id)->delete();

            // Kirim Notifikasi ke Merchant
            $merchant = DB::table('products')->select('merchant_id')->where('product_id', $product->product_id)->first();
            if ($merchant) {
                $merchant_user = DB::table('merchants')->select('user_id')->where('merchant_id', $merchant->merchant_id)->first();
                if ($merchant_user) {
                    $merchantUserModel = User::find($merchant_user->user_id);
                    if ($merchantUserModel) {
                        $merchantUserModel->notify(new ProductPurchasedNotification($purchase_id, $product->product_name));
                    }
                }
            }
        }

        // 5. Redirect ke detail pembelian
        return redirect("../detail_pembelian/$purchase_id");
    }
public function belilangsung(Request $request)
{
    date_default_timezone_set('Asia/Jakarta');

    $user_id = $request->user_id;
    $kode_pembelian = 'rkt_' . time();
    $jumlah_masuk_keranjang = $request->jumlah_masuk_keranjang;
    $voucher_pembelian = $request->voucher_pembelian;
    $voucher_ongkos_kirim = $request->voucher_ongkos_kirim;
    $potongan_pembelian = $request->potongan_pembelian;
    $alamat_purchase = $request->alamat_purchase;
    $courier_code = $request->courier_code;
    $service = $request->service;

    // Insert ke tabel checkouts
    $checkout_id = DB::table('checkouts')->insertGetId([
        'user_id' => $user_id,
    ]);

    // Insert claim voucher jika ada
    if ($voucher_pembelian) {
        DB::table('claim_vouchers')->insert([
            'checkout_id' => $checkout_id,
            'voucher_id' => $voucher_pembelian,
        ]);
    }
    if ($voucher_ongkos_kirim) {
        DB::table('claim_vouchers')->insert([
            'checkout_id' => $checkout_id,
            'voucher_id' => $voucher_ongkos_kirim,
        ]);
    }

    $metodes = $request->metode_pembelian;
    $harga_pembelians = $request->harga_pembelian;
    $purchase_id = null;

    if ($metodes == 1) {
        $purchase_id = DB::table('purchases')->insertGetId([
            'kode_pembelian' => $kode_pembelian,
            'user_id' => $user_id,
            'checkout_id' => $checkout_id,
            'alamat_purchase' => "",
            'harga_pembelian' => $harga_pembelians,
            'potongan_pembelian' => $potongan_pembelian,
            'status_pembelian' => "status1_ambil",
            'ongkir' => 0,
            'is_cancelled' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    if ($metodes == 2) {
        $ongkir = $request->ongkir;
        $purchase_id = DB::table('purchases')->insertGetId([
            'kode_pembelian' => $kode_pembelian,
            'user_id' => $user_id,
            'checkout_id' => $checkout_id,
            'alamat_purchase' => $alamat_purchase,
            'harga_pembelian' => $harga_pembelians,
            'potongan_pembelian' => $potongan_pembelian,
            'status_pembelian' => "status1",
            'courier_code' => $courier_code,
            'service' => $service,
            'ongkir' => $ongkir,
            'is_cancelled' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    $product_purchase = DB::table('products')
        ->select('product_id', 'heavy', 'price', 'merchant_id', 'product_name') // Pastikan ada kolom 'product_name'
        ->where('product_id', $request->product_id)
        ->first();

    if ($product_purchase) {
        // Insert ke product_purchases
        DB::table('product_purchases')->insert([
            'purchase_id' => $purchase_id,
            'product_id' => $product_purchase->product_id,
            'berat_pembelian_produk' => $jumlah_masuk_keranjang * $product_purchase->heavy,
            'jumlah_pembelian_produk' => $jumlah_masuk_keranjang,
            'harga_pembelian_produk' => $jumlah_masuk_keranjang * $product_purchase->price,
        ]);

        // Update stok
        $stok = DB::table('stocks')->select('stok')->where('product_id', $product_purchase->product_id)->first();
        if ($stok) {
            DB::table('stocks')->where('product_id', $product_purchase->product_id)->update([
                'stok' => $stok->stok - $jumlah_masuk_keranjang,
            ]);
        }

        // Kirim Notifikasi ke Merchant
        $merchant_user = DB::table('merchants')->select('user_id')->where('merchant_id', $product_purchase->merchant_id)->first();
        if ($merchant_user) {
            $merchantUserModel = User::find($merchant_user->user_id);
            if ($merchantUserModel) {
                $merchantUserModel->notify(new ProductPurchasedNotification($purchase_id, $product_purchase->product_name));
            }
        }
    }

    return response()->json($purchase_id);
}

    public function daftar_pembelian(Request $request)
    {
        setlocale(LC_TIME, 'id_ID');
        $user_id = $request->user_id;

        $purchases = DB::table('product_purchases')
            ->whereNotIn('status_pembelian', ["status1_ambil", "status1"])
            ->where('is_cancelled', 0)
            ->select('product_purchases.purchase_id', DB::raw("DATE_FORMAT(MAX(purchases.created_at), '%Y-%m-%d') as created_at"), 'products.product_id','kode_pembelian', 'status_pembelian', 'name','harga_pembelian', 'ongkir', DB::raw('MIN(product_name) as product_name'), DB::raw('MIN(price) as price'), DB::raw('MIN(jumlah_pembelian_produk) as jumlah_pembelian_produk'))
            ->where('purchases.user_id', $user_id)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('proof_of_payments', 'proof_of_payments.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('profiles', 'purchases.user_id', '=', 'profiles.user_id')
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->orderBy('product_purchases.purchase_id', 'desc')
            ->groupBy('purchase_id', 'kode_pembelian', 'status_pembelian', 'name','harga_pembelian', 'products.product_id','purchases.created_at', 'ongkir')->get()
            ->map(function ($item) {
            $item->created_at = \Carbon\Carbon::createFromFormat('Y-m-d', $item->created_at)->format('d M Y');
                if (($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') && DB::raw('COUNT(proof_of_payment_id) as proof_of_payment_id') != 0) {
                    $item->status_pembelian = 'Pembayaran Belum Dikonfirmasi';
                } else if ($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') {
                    $item->status_pembelian = 'Belum Bayar';
                } else if ($item->status_pembelian == 'status2_ambil' || $item->status_pembelian == 'status2') {
                    $item->status_pembelian = 'Sedang Dikemas';
                } elseif ($item->status_pembelian == 'status3') {
                    $item->status_pembelian = 'Dalam Perjalanan';
                } elseif ($item->status_pembelian == 'status3_ambil') {
                    $item->status_pembelian = 'Belum Diambil';
                } elseif ($item->status_pembelian == 'status4_ambil_a') {
                    $item->status_pembelian = 'Belum Dikonfirmasi Pembeli';
                } elseif ($item->status_pembelian == 'status4' || $item->status_pembelian == 'status4_ambil_b' || $item->status_pembelian == 'status5' || $item->status_pembelian == 'status5_ambil') {
                    $item->status_pembelian = 'Berhasil';
                } else {
                    $item->status_pembelian = 'Dibatalkan';
                }
                return $item;
            });
        return response()->json(
            $purchases
        );
    }

    public function menunggu_pembayaran(Request $request)
    {
        setlocale(LC_TIME, 'id_ID');
        $user_id = $request->user_id;
        $purchases = DB::table('product_purchases')
        ->whereIn('status_pembelian', ["status1_ambil", "status1"])
        ->where('is_cancelled', 0)
        ->select(
            'product_purchases.purchase_id',
            'products.product_id',
            'kode_pembelian',
            'status_pembelian',
            'name',
            'harga_pembelian',
            'ongkir',
            DB::raw('MIN(product_name) as product_name'),
            DB::raw('MIN(price) as price'),
            DB::raw('MIN(jumlah_pembelian_produk) as jumlah_pembelian_produk'),
            DB::raw('COUNT(proof_of_payments.proof_of_payment_id) as proof_of_payment_count')
        )
        ->where('purchases.user_id', $user_id)
        ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('profiles', 'purchases.user_id', '=', 'profiles.user_id')
        ->join('users', 'purchases.user_id', '=', 'users.id')
        ->leftJoin('proof_of_payments', 'proof_of_payments.purchase_id', '=', 'product_purchases.purchase_id')
        ->orderBy('product_purchases.purchase_id', 'desc')
        ->groupBy('purchase_id', 'kode_pembelian', 'status_pembelian', 'name','harga_pembelian', 'products.product_id', 'ongkir')
        ->get()
        ->map(function ($item) {
            if (($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') && $item->proof_of_payment_count != 0) {
                $item->status_pembelian = 'Pembayaran Belum Dikonfirmasi';
            } else if ($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') {
                $item->status_pembelian = 'Belum Bayar';
            }  elseif ($item->status_pembelian == 'status2_ambil' || $item->status_pembelian == 'status2') {
                $item->status_pembelian = 'Sedang Dikemas';
            } elseif ($item->status_pembelian == 'status3') {
                $item->status_pembelian = 'Dalam Perjalanan';
            } elseif ($item->status_pembelian == 'status3_ambil') {
                $item->status_pembelian = 'Belum Diambil';
            } elseif ($item->status_pembelian == 'status4_ambil_a') {
                $item->status_pembelian = 'Belum Dikonfirmasi Pembeli';
            } elseif ($item->status_pembelian == 'status4' || $item->status_pembelian == 'status4_ambil_b' || $item->status_pembelian == 'status5' || $item->status_pembelian == 'status5_ambil') {
                $item->status_pembelian = 'Berhasil';
            } else {
                $item->status_pembelian = 'Dibatalkan';
            }
            return $item;
        });


        return response()->json($purchases);
    }

    public function detail_pesanan(Request $request)
    {

        setlocale(LC_TIME, 'id_ID');
        $user_id = $request->user_id;


        $purchasesdetail = DB::table('purchases')->where('purchases.user_id', $user_id)->where('is_cancelled', 0)
            ->where('purchases.purchase_id', $request->purchase_id)
            ->join('users', 'purchases.user_id', '=', 'users.id')
            ->leftJoin('proof_of_payments', 'proof_of_payments.purchase_id', '=', 'purchases.purchase_id')
            ->join('profiles', 'purchases.user_id', '=', 'profiles.user_id')
            ->leftjoin('user_address', 'purchases.alamat_purchase', '=', 'user_address.user_address_id')
            ->groupBy('kode_pembelian', 'no_resi', 'courier_code', 'service', 'user_address.province_name', 'user_address.city_name', 'user_address.subdistrict_name', 'user_address.user_street_address', 'profiles.no_hp')
            ->select('kode_pembelian', 'no_resi', 'courier_code', 'service', 'user_address.province_name', 'user_address.city_name', 'user_address.subdistrict_name', 'user_address.user_street_address', 'profiles.no_hp', DB::raw('COUNT(proof_of_payments.proof_of_payment_id) as proof_of_payment_count'), DB::raw('MAX(purchases.purchase_id) as purchase_id'), DB::raw('CAST(SUM(harga_pembelian) AS UNSIGNED) as harga_pembelian'), DB::raw("DATE_FORMAT(MAX(purchases.created_at), '%Y-%m-%d') as created_at"), DB::raw('MAX(status_pembelian) as status_pembelian'), DB::raw('MAX(ongkir) as ongkir'))
            ->orderBy('kode_pembelian', 'desc')->get()
            ->map(function ($item) {
                $item->created_at = \Carbon\Carbon::createFromFormat('Y-m-d', $item->created_at)->format('d M Y');
            if (($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') && $item->proof_of_payment_count != 0) {
                $item->status_pembelian = 'Pembayaran Belum Dikonfirmasi';
            } else if ($item->status_pembelian == 'status1' || $item->status_pembelian == 'status1_ambil') {
                $item->status_pembelian = 'Belum Bayar';
            } elseif ($item->status_pembelian == 'status2_ambil' || $item->status_pembelian == 'status2') {
                $item->status_pembelian = 'Sedang Dikemas';
            } elseif ($item->status_pembelian == 'status3') {
                $item->status_pembelian = 'Dalam Perjalanan';
            } elseif ($item->status_pembelian == 'status3_ambil') {
                $item->status_pembelian = 'Belum Diambil';
            } elseif ($item->status_pembelian == 'status4_ambil_a') {
                $item->status_pembelian = 'Belum Dikonfirmasi Pembeli';
            } elseif ($item->status_pembelian == 'status4' || $item->status_pembelian == 'status4_ambil_b' || $item->status_pembelian == 'status5' || $item->status_pembelian == 'status5_ambil') {
                $item->status_pembelian = 'Berhasil';
            } else {
                $item->status_pembelian = 'Dibatalkan';
            }
            if ($item->courier_code == "pos") {
                $item->courier_code = "POS Indonesia (POS)";
            } else if ($item->courier_code == "jne") {
                $item->courier_code = "Jalur Nugraha Eka (JNE)";
            } else {
                $item->courier_code = '';
            }
                return $item;
            });

        $purchases = DB::table('purchases')
            ->where('purchases.user_id', $user_id)
            ->where('purchases.purchase_id', $request->purchase_id)
            ->leftjoin('product_purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->leftjoin('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->get();

        return response()->json([
            'purchasesdetail' => $purchasesdetail,
            'purchases' => $purchases,
        ]);
    }

    public function hapus(Request $request)
    {
        if (DB::table('purchases')
            ->where('kode_pembelian', '=', $request->kode_pembelian)
            ->update(['is_cancelled' => 1])
        ) {

            return response()->json(
                200
            );
        }
    }

public function PostBuktiPembayaran(Request $request)
{
    // Debugging: cek semua data yang diterima
    \Log::debug('Request Data:', $request->all());

    // Periksa apakah file ada
    if ($request->hasFile('proof_of_payment_image')) {
        // Ambil file dan bersihkan nama file jika ada karakter tidak terduga
        $fileField = 'proof_of_payment_image';
        $proof_of_payment_image = $request->file($fileField);

        // Debugging: cek apakah file berhasil diambil
        if ($proof_of_payment_image) {
            \Log::debug('File Uploaded:', ['file_name' => $proof_of_payment_image->getClientOriginalName()]);

            // Tentukan nama file dan folder tujuan
            $proof_of_payment_image_name = time() . '_' . $proof_of_payment_image->getClientOriginalName();
            $tujuan_upload = public_path('asset/u_file/proof_of_payment_image'); // Gunakan public_path() untuk memastikan path yang benar

            // Debugging: cek folder tujuan upload
            \Log::debug('Upload Folder Path:', ['upload_folder' => $tujuan_upload]);

            // Cek apakah folder tujuan ada
            if (!is_dir($tujuan_upload)) {
                // Jika folder tidak ada, buat foldernya
                \Log::debug('Folder tidak ada, membuat folder...');
                mkdir($tujuan_upload, 0777, true); // Membuat folder jika belum ada
            }

            // Debugging: cek apakah folder berhasil dibuat
            if (is_dir($tujuan_upload)) {
                \Log::debug('Folder sudah ada atau berhasil dibuat.');
            } else {
                \Log::debug('Gagal membuat folder.');
            }

            // Pindahkan file ke folder tujuan
            $moveResult = $proof_of_payment_image->move($tujuan_upload, $proof_of_payment_image_name);

            // Debugging: cek apakah file berhasil dipindahkan
            if ($moveResult) {
                \Log::debug('File berhasil dipindahkan:', ['file_path' => $tujuan_upload . '/' . $proof_of_payment_image_name]);
            } else {
                \Log::debug('Gagal memindahkan file.');
            }

            // Jika file berhasil dipindahkan, lanjutkan ke proses database
            if (file_exists($tujuan_upload . '/' . $proof_of_payment_image_name)) {
                $purchase_ids = $request->purchase_id;

                // Debugging: cek purchase_id yang dikirim
                \Log::debug('Purchase ID:', ['purchase_id' => $purchase_ids]);

                // Masukkan data ke database
                DB::table('proof_of_payments')->insert([
                    'purchase_id' => $purchase_ids,
                    'proof_of_payment_image' => $proof_of_payment_image_name,
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'File successfully uploaded'
                ]);
            } else {
                return response()->json([
                    'error' => 'File failed to upload properly'
                ], 500);
            }
        } else {
            // Debugging: jika file tidak ada
            \Log::debug('No file uploaded.');
            return response()->json([
                'error' => 'No image file provided'
            ], 400);
        }
    } else {
        // Debugging: jika tidak ada file dalam request
        \Log::debug('No file provided in the request');
        
        return response()->json([
            'error' => 'No image file provided'
        ], 400);
    }
}

}

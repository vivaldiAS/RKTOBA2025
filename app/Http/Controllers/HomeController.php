<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama pada setiap tipe pengguna.
     */

    public function index() {

        // Memastikan apakah aplikasi diakses dengan menggunakan akun.

        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->whereIn('is_admin', [1, 2])->first();

            // set logout saat habis session dan auth

            if(!Auth::check()){
                return redirect("./logout");
            }
        }


        // Jika dipastikan diakses menggunakan akun dan masuk sebagai Admin maka dapat mengakses halaman utama pada Admin.

        if (isset($cek_admin_id)) {
            // Mengambil data dari API
            $client = new Client();
            $response = $client->get('https://kreatif.tobakab.go.id/api/pembelian');
            $apiData = json_decode($response->getBody()->getContents(), true);
        
            $purchasesAPI = $apiData['purchases'];
        
            // Mengambil data dari database
            $purchasesDB = DB::table("purchases as p")
                ->join("profiles", "profiles.user_id", "=", "p.user_id")
                ->joinSub(DB::table("product_purchases as pp")
                    ->join("products as p", "pp.product_id", "p.product_id")
                    ->join("merchants as m", "m.merchant_id", "p.merchant_id")
                    ->select("pp.purchase_id", "m.nama_merchant"), "mp", function($join){
                        $join->on("p.purchase_id", "=", "mp.purchase_id");
                    })
                ->leftJoin("proof_of_payments as ppp", "ppp.purchase_id", "=", "p.purchase_id")
                ->select("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian", "ppp.proof_of_payment_image")
                ->where('p.is_cancelled', 0)
                ->where(function($query) {
                    $query->where("ppp.proof_of_payment_image", "!=", null)
                          ->where(function($query) {
                              $query->where("p.status_pembelian", "status1")
                                    ->orWhere("p.status_pembelian", "status1_ambil");
                          });
                })
                ->groupBy("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian", "ppp.proof_of_payment_image")
                ->get();
        
            // Mengambil data statistik dari database
            $jumlah_pesanan = DB::table('purchases')->where('is_cancelled', 0)->count();
            $jumlah_pesanan_perlu_konfirmasi = DB::table('purchases')
                ->where('is_cancelled', 0)
                ->where("proof_of_payment_image", "!=", null)
                ->where(function($query) {
                    $query->where("status_pembelian", "status1")
                          ->orWhere("status_pembelian", "status1_ambil");
                })
                ->leftJoin("proof_of_payments", "proof_of_payments.purchase_id", "=", "purchases.purchase_id")
                ->count();
        
            $jumlah_pengguna = DB::table('profiles')->count();
            $jumlah_pengguna_perlu_verifikasi = DB::table('verify_users')
                ->where('is_verified', "!=", 1)
                ->orWhere('is_verified', null)
                ->count();
        
            $toko = DB::table('merchants')->count();
            $toko_perlu_verifikasi = DB::table('merchants')
                ->where('is_verified', "!=", 1)
                ->orWhere('is_verified', null)
                ->count();
        
            return view('admin.index', [
                "purchasesDB" => $purchasesDB,
                "purchasesAPI" => $purchasesAPI,
                "jumlah_pesanan" => $jumlah_pesanan,
                "jumlah_pesanan_perlu_konfirmasi" => $jumlah_pesanan_perlu_konfirmasi,
                "jumlah_pengguna" => $jumlah_pengguna,
                "jumlah_pengguna_perlu_verifikasi" => $jumlah_pengguna_perlu_verifikasi,
                "jumlah_toko" => $toko,
                "jumlah_toko_perlu_verifikasi" => $toko_perlu_verifikasi,
                "cek_admin_id" => $cek_admin_id,
            ]);
        }

        // Jika dipastikan diakses menggunakan akun dan masuk sebagai Toko maka dapat mengakses halaman utama pada Toko.

        if(Session::get('toko')){
            return redirect('./toko');
        }


        // Jika dipastikan diakses menggunakan akun maupun tidak menggunakan akun maka ditampilkan halaman utama yang sama.

        else{

            $produk_yang_terjual = DB::table('product_purchases')
            ->select(DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id', 'products.product_name', 'products.type', 'products.category_id', 'nama_kategori',
            'products.merchant_id', 'nama_merchant','products.price', 'city_name', 'subdistrict_name', 'province_name')
            ->where('is_deleted', 0)->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->groupBy('product_purchases.product_id', 'products.product_name', 'products.category_id','nama_kategori',
            'products.merchant_id', 'nama_merchant', 'products.price', 'city_name', 'subdistrict_name', 'province_name', 'products.type')
            ->orderBy('count_product_purchases', 'desc')->get();

            $produk_makanan_minuman_terlaris = DB::table('product_purchases')
            ->select(DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id', 'products.product_name', 'products.type', 'products.category_id', 'nama_kategori',
            'products.merchant_id', 'nama_merchant', 'products.price', 'city_id', 'subdistrict_id', 'city_name',
            'subdistrict_name', 'province_name')
            ->where('merchants.is_closed', 0)
            ->where('is_deleted', 0)
            ->where(function($query) {
                $query->where('products.category_id', 1)
                      ->orWhere('products.category_id', 7);
            })
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join('merchant_address', 'products.merchant_id', '=', 'merchant_address.merchant_id')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->groupBy('product_purchases.product_id', 'products.product_name', 'products.category_id','nama_kategori',
            'products.merchant_id', 'nama_merchant', 'products.type','products.price', 'city_id', 'subdistrict_id', 'city_name',
            'subdistrict_name', 'province_name')->orderBy('count_product_purchases', 'desc')->limit(5)->get();

            $produk_pakaian_terlaris = DB::table('product_purchases')
            ->select(DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id', 'products.product_name', 'products.type', 'products.category_id', 'nama_kategori',
            'products.merchant_id', 'nama_merchant', 'products.price', 'city_name', 'subdistrict_name', 'province_name')
            ->where('merchants.is_closed', 0)->where('is_deleted', 0)->where('products.category_id', 2)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->groupBy('product_purchases.product_id', 'products.product_name', 'products.category_id','nama_kategori',
            'products.merchant_id', 'nama_merchant','products.type', 'products.price', 'city_name', 'subdistrict_name', 'province_name')
            ->orderBy('count_product_purchases', 'desc')->limit(5)->get();

            $carousels = DB::table('carousels')->orderBy('id', 'desc')->get();

            $count_product = DB::table('products')->select(DB::raw('COUNT(*) as count_product'))->first();

            $new_products = DB::table('products')->where('merchants.is_closed', 0)->where('is_deleted', 0)
            ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->orderBy('product_id', 'desc')->limit(10)->get();

            $cek_http = DB::table('carousels')->where('link_carousel', 'like', 'https://'."%")->orwhere('link_carousel', 'like', 'http://'."%")->first();
            $cek_www = DB::table('carousels')->where('link_carousel', 'like', 'www.'."%")->first();

            $categories = [
                [
                    "icon_image"=> "asset/Image/category/food.png",
                    "url"=> "/produk/kategori[1]",
                    "name"=> "Makanan",
                ],
                [
                    "icon_image"=> "asset/Image/category/drink.png",
                    "url"=> "/produk/kategori[7]",
                    "name"=> "Minuman",
                ],
                [
                    "icon_image"=> "asset/Image/category/dresss.png",
                    "url"=> "/produk/kategori[2]",
                    "name"=> "Pakaian",
                ],
                [
                    "icon_image"=> "asset/Image/category/souvenir.png",
                    "url"=> "/produk/kategori[9]",
                    "name"=> "Souvenir",
                ],
                [
                    "icon_image"=> "asset/Image/category/tools.png",
                    "url"=> "/produk/kategori[8]",
                    "name"=> "Domestik",
                ],
                [
                    "icon_image"=> "asset/Image/category/ulos.png",
                    "url"=> "/produk/kategori[3]",
                    "name"=> "Ulos",
                ],
                [
                    "icon_image"=> "asset/Image/category/Vector.jpeg",
                    "url"=> "/produk",
                    "name"=> "Semua",
                ],
            ];

            return view('user.index')->with('new_products', $new_products)->with('produk_makanan_minuman_terlaris', $produk_makanan_minuman_terlaris)
            ->with('produk_pakaian_terlaris', $produk_pakaian_terlaris)->with('carousels', $carousels)->with('cek_http', $cek_http)
            ->with("categories", $categories)
            ->with('cek_www', $cek_www)->with('count_product', $count_product);
        }
    }


    /**
     * Menampilkan halaman dashboard pada setiap tipe pengguna.
     */

    public function dashboard() {

        // set logout saat habis session dan auth

        if(!Auth::check()){
            return redirect("./logout");
        }


        // Jika dipastikan diakses menggunakan akun dan masuk sebagai Toko maka dapat mengakses halaman dashboard pada Toko.

        if(Session::get('toko')){
            $toko = Session::get('toko');

            $cek_purchases = DB::table('product_purchases')->select('product_purchases.purchase_id')->where('merchant_id', $toko)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->orderBy('product_purchases.purchase_id', 'desc')->groupBy('purchase_id')
            ->orderBy('purchases.updated_at', 'desc')->get();

            $purchases = DB::table('purchases')->join('users', 'purchases.user_id', '=', 'users.id')->where('is_cancelled', 0)->orderBy('purchases.updated_at', 'desc')->get();

            $count_status = DB::table('product_purchases')->select('purchases.purchase_id')->where('merchant_id', $toko)
            ->join('purchases', 'product_purchases.purchase_id', '=', 'purchases.purchase_id')
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')->groupBy('purchases.purchase_id')->get();

            $jumlah_status2 = 0;
            $jumlah_status2_ambil = 0;
            $jumlah_status3 = 0;
            $jumlah_status3_ambil = 0;
            $jumlah_status4_ambil_a = 0;
            $jumlah_status4 = 0;
            $jumlah_status4_ambil_b = 0;
            $jumlah_status5 = 0;
            $jumlah_status5_ambil = 0;
            foreach($count_status as $count_status){
                $count_purchases_status2[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status2')->count();
                $jumlah_status2 = array_sum($count_purchases_status2);

                $count_purchases_status2_ambil[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status2_ambil')->count();
                $jumlah_status2_ambil = array_sum($count_purchases_status2_ambil);

                $count_purchases_status3[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status3')->count();
                $jumlah_status3 = array_sum($count_purchases_status3);

                $count_purchases_status3_ambil[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status3_ambil')->count();
                $jumlah_status3_ambil = array_sum($count_purchases_status3_ambil);

                $count_purchases_status4_ambil_a[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status4_ambil_a')->count();
                $jumlah_status4_ambil_a = array_sum($count_purchases_status4_ambil_a);

                $count_purchases_status4[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status4')->count();
                $jumlah_status4 = array_sum($count_purchases_status4);

                $count_purchases_status4_ambil_b[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status4_ambil_b')->count();
                $jumlah_status4_ambil_b = array_sum($count_purchases_status4_ambil_b);

                $count_purchases_status5[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status5')->count();
                $jumlah_status5 = array_sum($count_purchases_status5);

                $count_purchases_status5_ambil[] = DB::table('purchases')->where('purchase_id', $count_status->purchase_id)->where('status_pembelian', 'status5_ambil')->count();
                $jumlah_status5_ambil = array_sum($count_purchases_status5_ambil);
            }
            $jumlah_pesanan_sedang_berlangsung = $jumlah_status2 + $jumlah_status2_ambil + $jumlah_status3
            + $jumlah_status3_ambil + $jumlah_status4_ambil_a;

            $jumlah_pesanan_berhasil_belum_dibayar = $jumlah_status4 + $jumlah_status4_ambil_b;

            $jumlah_pesanan_berhasil_telah_dibayar = $jumlah_status5 + $jumlah_status5_ambil;
            
            return view('user.toko.dashboard')->with('toko', $toko)->with('cek_purchases', $cek_purchases)->with('purchases', $purchases)
            ->with('jumlah_pesanan_sedang_berlangsung', $jumlah_pesanan_sedang_berlangsung)->with('jumlah_pesanan_berhasil_belum_dibayar', $jumlah_pesanan_berhasil_belum_dibayar)
            ->with('jumlah_pesanan_berhasil_telah_dibayar', $jumlah_pesanan_berhasil_telah_dibayar);
        }


        // Jika dipastikan diakses menggunakan akun dan masuk sebagai Pengguna maka dapat mengakses halaman dashboard pada Pengguna.

        if(Auth::user()){
            $user_id = Auth::user()->id;

            $cek_purchases = DB::table('purchases')->where('user_id', $user_id)->first();

            $purchases = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)
            ->join('users', 'purchases.user_id', '=', 'users.id')->orderBy('purchases.updated_at', 'desc')->get();


            $count_status1 = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status1')->count();
            $count_status1_ambil = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status1_ambil')->count();
            $count_status2 = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status2')->count();
            $count_status2_ambil = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status2_ambil')->count();
            $count_status3 = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status3')->count();
            $count_status3_ambil = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status3_ambil')->count();
            $count_status4_ambil_a = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status4_ambil_a')->count();
            $jumlah_pesanan_sedang_berlangsung = $count_status1 + $count_status1_ambil + $count_status2 + $count_status2_ambil + $count_status3 + $count_status3_ambil + $count_status4_ambil_a;

            $count_status4 = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status4')->count();
            $count_status4_ambil_b = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status4_ambil_b')->count();
            $count_status5 = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status5')->count();
            $count_status5_ambil = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 0)->where('status_pembelian', 'status5_ambil')->count();
            $jumlah_pesanan_berhasil = $count_status4 + $count_status4_ambil_b + $count_status5 + $count_status5_ambil;

            $count_proof_of_payment = DB::table('proof_of_payments')->select(DB::raw('COUNT(*) as count_proof_of_payment'))->first();

            $count_cancelled_purchases = DB::table('purchases')->where('user_id', $user_id)->where('is_cancelled', 1)->count();


            return view('user.dashboard')->with('cek_purchases', $cek_purchases)->with('purchases', $purchases)
            ->with('count_proof_of_payment', $count_proof_of_payment)->with('jumlah_pesanan_sedang_berlangsung', $jumlah_pesanan_sedang_berlangsung)
            ->with('jumlah_pesanan_berhasil', $jumlah_pesanan_berhasil)->with('count_cancelled_purchases', $count_cancelled_purchases);
        }

        else{
            return redirect('./');
        }
    }

    // function landing page untuk tiket museum kaldera
    public function landing_tiketmuseum() {
        if(Auth::check()){
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
        }

        if(isset($cek_admin_id)){
            $data = DB::table("purchases as p")
                ->join("profiles", "profiles.user_id", "=", "p.user_id")
                ->joinSub(DB::table("product_purchases as pp")
                    ->join("products as p", "pp.product_id", "p.product_id")
                    ->join("merchants as m", "m.merchant_id", "p.merchant_id")
                    ->select("pp.purchase_id", "m.nama_merchant"), "mp", function($join){
                        $join->on("p.purchase_id", "=", "mp.purchase_id");
                    })
                ->leftJoin("proof_of_payments as ppp", "ppp.purchase_id", "=", "p.purchase_id")
                ->select("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian","ppp.proof_of_payment_image")
                ->where('p.is_cancelled', 0)->where("ppp.proof_of_payment_image", "!=", null)->where("p.status_pembelian", "status1")->orwhere("p.status_pembelian", "status1_ambil")->where("ppp.proof_of_payment_image", "!=", null)
                ->groupBy("p.purchase_id", "profiles.name", "p.kode_pembelian", "mp.nama_merchant", "p.created_at", "p.updated_at", "p.status_pembelian", "ppp.proof_of_payment_image")
                ->get();

            $jumlah_pesanan = DB::table('purchases')->where('is_cancelled', 0)->count();
            $jumlah_pesanan_perlu_konfirmasi = DB::table('purchases')
            ->leftJoin("proof_of_payments", "proof_of_payments.purchase_id", "=", "purchases.purchase_id")
            ->where('is_cancelled', 0)->where("proof_of_payment_image", "!=", null)->where("status_pembelian", "status1")
            ->orwhere("status_pembelian", "status1_ambil")->where("proof_of_payment_image", "!=", null)->count();

            $jumlah_pengguna = DB::table('profiles')->count();
            $jumlah_pengguna_perlu_verifikasi = DB::table('verify_users')
            ->where('is_verified', "!=", 1)->orwhere('is_verified', null)->groupBy("user_id",)
            ->count();

            $toko = DB::table('merchants')->count();
            $toko_perlu_verifikasi = DB::table('merchants')
            ->where('is_verified', "!=", 1)->orwhere('is_verified', null)
            ->count();

            return view('user.landingpage_experience', [
                "purchases"=> $data,
                "jumlah_pesanan"=> $jumlah_pesanan,
                "jumlah_pesanan_perlu_konfirmasi"=> $jumlah_pesanan_perlu_konfirmasi,
                "jumlah_pengguna"=> $jumlah_pengguna,
                "jumlah_pengguna_perlu_verifikasi"=> $jumlah_pengguna_perlu_verifikasi,
                "jumlah_toko"=> $toko,
                "jumlah_toko_perlu_verifikasi"=> $toko_perlu_verifikasi,

            ]);
        }

        if(Session::get('toko')){
            return redirect('./toko');
        }

        else{

            $total_penjualan_produk = DB::table('product_purchases')->select(DB::raw('SUM(jumlah_pembelian_produk) as count_products'),
            'product_purchases.product_id')->where('is_deleted', 0)
            ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->groupBy('product_purchases.product_id')->orderBy('count_products', 'desc')->limit(10)->get();

            $carousels = DB::table('carousels')->orderBy('id', 'desc')->get();

            $count_products = DB::table('products')->select(DB::raw('COUNT(*) as count_products'))->first();

            $products = DB::table('products')->where('is_deleted', 0)->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->orderBy('product_id', 'desc')->limit(10)->get();

            $cek_http = DB::table('carousels')->where('link_carousel', 'like', 'https://'."%")->orwhere('link_carousel', 'like', 'http://'."%")->first();
            $cek_www = DB::table('carousels')->where('link_carousel', 'like', 'www.'."%")->first();

            return view('user.tiket.index')->with('products', $products)->with('total_penjualan_produk', $total_penjualan_produk)->with('carousels', $carousels)->with('cek_http', $cek_http)
            ->with('cek_www', $cek_www)->with('count_products', $count_products);
        }
    }

    public function  detailtiket() {

            return view('user.tiket.detail');

        }


    public function  pembayaran() {

            return view('user.tiket.pembayaran');

    }

    public function searchPurchases(Request $request) {
        $client = new Client();
        $response = $client->get('https://kreatif.tobakab.go.id/api/pembelian');
        $apiData = json_decode($response->getBody()->getContents(), true);
        $purchasesAPI = $apiData['purchases'];
    
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
    
        if ($startDate && $endDate) {
            $purchasesAPI = array_filter($purchasesAPI, function ($purchase) use ($startDate, $endDate) {
                $purchaseDate = strtotime($purchase['created_at']);
                return $purchaseDate >= strtotime($startDate) && $purchaseDate <= strtotime($endDate);
            });
        }
    
        return response()->json([
            "purchasesAPI" => array_values($purchasesAPI),
            "startDate" => $startDate,
            "endDate" => $endDate,
        ]);
    }

    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function index_delshop()
    {
        $availableProductsCount = 0;
        $soldProduct = 0;
        $data = [];
    
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 2)->first();
    
            if ($cek_admin_id) {
                $stocks = Stock::with(['merchant'])
                    ->where('sisa_stok', '>', 0)
                    ->get();
    
                $transaksi = Transaksi::all();
    
                $availableProductsCount = $stocks->sum('sisa_stok');
                $soldProduct = $transaksi->sum('jumlah_barang_keluar');
    
                $client = new Client();
                $response_product = $client->get($this->baseApiUrl . '/listdaftarproduk');
                $response_category = $client->get($this->baseApiUrl . '/pilihkategori');
    
                if ($response_product->getStatusCode() !== 200 || $response_category->getStatusCode() !== 200) {
                    throw new \Exception('Gagal mengambil data produk atau kategori dari API');
                }
    
                $products = json_decode($response_product->getBody()->getContents(), true);
                $categories = json_decode($response_category->getBody()->getContents(), true);
    
                $productMap = collect($products)->keyBy('product_id');
                $categoryMap = collect($categories)->keyBy('category_id');
    
                $data = $stocks->map(function ($stock) use ($productMap, $categoryMap) {
                    $product = $productMap->get($stock->product_id);
    
                    $categoryId = $product['category_id'] ?? null;
    
                    $categoryName = $categoryMap->get($categoryId)['nama_kategori'] ?? 'Kategori Tidak Ditemukan';
    
                    return [
                        'stock_id' => $stock->stock_id,
                        'product_name' => $product['product_name'] ?? 'Produk Tidak Ditemukan',
                        'merchant_name' => $stock->merchant->nama_merchant,
                        'stok' => $stock->jumlah_stok,
                        'sisa_stok' => $stock->sisa_stok,
                        'kategori' => $categoryName,
                        'spesifikasi' => $stock->spesifikasi,
                        'hargamodal' => $stock->hargamodal,
                        'hargajual' => $stock->hargajual,
                        'tanggal_masuk' => $stock->tanggal_masuk,
                        'tanggal_expired' => $stock->tanggal_expired,
                    ];
                });
    
                $data = $data->sortByDesc('stock_id')->values()->all();
            } 
        } 
    
        return view('admin.delshop.index', [
            'data' => $data,
            'availableProductsCount' => $availableProductsCount,
            'soldProduct' => $soldProduct
        ]);
    }
    

    public function produk_delshop(){
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 2)->first();
    
            if ($cek_admin_id) {
                        $stocks = Stock::with(['merchant'])
                            ->where('sisa_stok', '>', 0)
                            ->get();
                
                        $client = new Client();
                
                        $response_product = $client->get($this->baseApiUrl . '/listdaftarproduk');
                        $response_category = $client->get($this->baseApiUrl . '/pilihkategori');
                
                        if ($response_product->getStatusCode() !== 200 || $response_category->getStatusCode() !== 200) {
                            throw new \Exception('Gagal mengambil data produk atau kategori dari API');
                        }
                
                        $products = json_decode($response_product->getBody()->getContents(), true);
                        $categories = json_decode($response_category->getBody()->getContents(), true);
                
                        $productMap = collect($products)->keyBy('product_id');
                        $categoryMap = collect($categories)->keyBy('category_id');
                
                        $data = $stocks->map(function ($stock) use ($productMap, $categoryMap) {
                            $product = $productMap->get($stock->product_id);
                
                            $categoryId = $product['category_id'] ?? null;
                
                            $categoryName = $categoryMap->get($categoryId)['nama_kategori'] ?? 'Kategori Tidak Ditemukan';
                
                            return [
                                'stock_id' => $stock->stock_id,
                                'product_name' => $product['product_name'] ?? 'Produk Tidak Ditemukan',
                                'merchant_name' => $stock->merchant->nama_merchant,
                                'stok' => $stock->jumlah_stok,
                                'sisa_stok' => $stock->sisa_stok,
                                'kategori' => $categoryName,
                                'spesifikasi' => $stock->spesifikasi,
                                'hargamodal' => $stock->hargamodal,
                                'hargajual' => $stock->hargajual,
                                'tanggal_masuk' => $stock->tanggal_masuk,
                                'tanggal_expired' => $stock->tanggal_expired,
                            ];
                        });
                
                        $data = $data->sortByDesc('stock_id')->values()->all();
                
                        return view('admin.delshop.produk', ['data' => $data]);
                    } 
        } 
        return view('admin.delshop.produk');
    }

    public function hapusproduk_delshop($id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $stock->delete();

            return redirect()->route('delshop.produk');

        } catch (\Exception $e) {
            return view('admin.delshop.index')->withErrors($e->getMessage());
        }
    }

    public function editProduk($id)
    {
        $stock = Stock::with(['merchant'])->findOrFail($id);
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 2)->first();
            if ($cek_admin_id) {
                try {
                    try {
                        $merchants = Merchants::all();
                        $categories = Category::all();
                        $products = Product::all();
                        return view('admin.delshop.edit_produk', compact('stock','merchants','categories','products'));
                    } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                } catch (\Exception $e) {
                    return view('admin.delshop.index')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }

    public function updateProduk(Request $request, $id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $stock->merchant_id = $request->namaToko;
            $stock->product_id = $request->namaProduk;
            $stock->spesifikasi = $request->spesifikasi;
            $stock->lokasi = $request->lokasi;
            $stock->jumlah_stok = $request->jumlah;
            $stock->sisa_stok = $request->jumlah;
            $stock->hargamodal = $request->hargamodal;
            $stock->hargajual = $request->hargajual;
            $stock->tanggal_expired = $request->tanggalExpired;
            $stock->save();
    
            return redirect()->route('delshop.produk')->with('success', 'Produk berhasil diperbarui');

        } catch (\Exception $e) {
            return view('admin.delshop.produk')->withErrors($e->getMessage());
        }
    }



}

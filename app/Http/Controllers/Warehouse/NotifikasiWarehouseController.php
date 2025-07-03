<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Category;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotifikasiWarehouseController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function getNotifications()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    $today = Carbon::today();
                    $barangMasuk = Carbon::today()->subDays(1)->toDateString();
                    $barangExp = Carbon::today()->addDays(30)->toDateString();
    
                    $newProducts = DB::table('stocks_warehouse')
                                    ->join('products', 'stocks_warehouse.product_id', '=', 'products.product_id')
                                    ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
                                    ->join('categories', 'products.category_id', '=', 'categories.category_id')
                                    ->select(
                                        'stocks_warehouse.*',
                                        'products.product_name',
                                        'merchants.nama_merchant as merchant_name',
                                        'categories.nama_kategori as kategori_produk'
                                    )
                                    ->where('tanggal_masuk', '>=', $barangMasuk)
                                    ->get();
    
                    $expiringProducts = DB::table('stocks_warehouse')
                                        ->join('products', 'stocks_warehouse.product_id', '=', 'products.product_id')
                                        ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
                                        ->join('categories', 'products.category_id', '=', 'categories.category_id')
                                        ->select(
                                            'stocks_warehouse.*',
                                            'products.product_name',
                                            'merchants.nama_merchant as merchant_name',
                                            'categories.nama_kategori as kategori_produk'
                                        )
                                        ->where('tanggal_expired', '<=', $barangExp)
                                        ->where('sisa_stok', '>', 0) // Only include products with stock greater than 0
                                        ->get();
    
                    return view('admin.warehouse.notifikasi', compact('newProducts', 'expiringProducts'));
                } catch (\Exception $e) {
                    return view('admin.warehouse.index')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }
    
    public function getNotificationsCount()
    {
        try {
            $barangMasuk = Carbon::today()->subDays(1)->toDateString();
            $barangExp = Carbon::today()->addDays(30)->toDateString();
        
            $newProductsCount = DB::table('stocks_warehouse')
                ->where('tanggal_masuk', '>=', $barangMasuk)
                ->count();
        
            $expiringProductsCount = DB::table('stocks_warehouse')
                ->where('tanggal_expired', '<=', $barangExp)
                ->where('sisa_stok','>',0)
                ->count();
        
            $totalCount = $newProductsCount + $expiringProductsCount;
        
            return response()->json(['count' => $totalCount, 'newProductsCount' => $newProductsCount, 'expiringProductsCount' => $expiringProductsCount]);
        } catch (\Exception $e) {
            return view('admin.warehouse.index')->withErrors($e->getMessage());
        }
    }
}

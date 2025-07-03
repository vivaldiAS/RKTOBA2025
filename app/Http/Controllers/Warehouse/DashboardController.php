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

class DashboardController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
    
        $id = Auth::user()->id;
        $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
        if (!$cek_admin_id) {
            return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    
        try {
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
    
            return view('admin.warehouse.index', [
                'data' => $data,
                'availableProductsCount' => $availableProductsCount,
                'soldProduct' => $soldProduct
            ]);
    
        } catch (\Exception $e) {
            // Handle the exception and pass the error message to the view
            return view('admin.warehouse.index', ['error' => $e->getMessage()]);
        }
    }
    
}

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

class LaporanWarehouseController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function laporanpemesanan()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    $client = new Client();
                    $response = $client->get($this->baseApiUrl . '/pembelian');
                    if ($response->getStatusCode() === 200) {
                        $data = json_decode($response->getBody()->getContents(), true);
                        $purchases = $data['purchases'] ?? [];
                    } else {
                        $purchases = [];
                    }
                    return view('admin.warehouse.laporan_pemesanan', compact('purchases'));
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

    public function LaporanStok()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    try {
                        $client = new Client();
                        $response_product = $client->get($this->baseApiUrl . '/listdaftarproduk');
            
                        if ($response_product->getStatusCode() !== 200) {
                            throw new \Exception('Gagal mengambil data produk dari API');
                        }
                        $products = json_decode($response_product->getBody()->getContents(), true);
                
                        $response_category = $client->get($this->baseApiUrl . '/pilihkategori');
                        if ($response_category->getStatusCode() !== 200) {
                            throw new \Exception('Gagal mengambil data kategori dari API');
                        }
                        $categories = json_decode($response_category->getBody()->getContents(), true);
                
                        $categoryMap = collect($categories)->keyBy('category_id');
                
                        $stocks = Stock::with(['merchant', 'transaksi'])->get();
                
                        $data = $stocks->map(function ($stock) use ($products, $categoryMap) {
                            $product = collect($products)->firstWhere('product_id', $stock->product_id);
                
                            $category = $product ? $categoryMap->get($product['category_id']) : null;
                
                            $totalBarangKeluar = $stock->transaksi->sum('jumlah_barang_keluar');
                
                            $stokTersisa = max($stock->jumlah_stok - $totalBarangKeluar, 0);
                
                            $transaksiTerakhir = $stock->transaksi->max('created_at');
                
                            $transaksiTerakhir = $transaksiTerakhir ? $transaksiTerakhir->toDateTimeString() : null;
                
                            return [
                                'stock_id' => $stock->stock_id,
                                'product_name' => $product['product_name'] ?? 'Produk Tidak Ditemukan',
                                'merchant_name' => $stock->merchant->nama_merchant,
                                'stok' => $stock->jumlah_stok,
                                'kategori' => $category['nama_kategori'] ?? 'Belum dikategorikan',
                                'hargamodal' => $stock->hargamodal,
                                'hargajual' => $stock->hargajual,
                                'tanggal_expired' => $stock->tanggal_expired,
                                'transaksi_terakhir' => $transaksiTerakhir,
                                'total_barang_keluar' => $totalBarangKeluar,
                                'tanggal_masuk' => $stock->tanggal_masuk,
                                'stok_tersisa' => $stokTersisa,
                            ];
                        });
            
                        $data = $data->sortByDesc('tanggal_masuk')->values()->all();
                        return view('admin.warehouse.laporan_stok', compact('data'));     
            
                    } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
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

    public function searchByDate(Request $request)
    {
        $client = new Client();
        $response = $client->get('https://kreatif.tobakab.go.id/api/pembelian');
        $apiData = json_decode($response->getBody()->getContents(), true);
        $purchasesAPI = $apiData['purchases'];
    
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
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

}

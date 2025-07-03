<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\Category;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;

class StokController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function index()
    {
        try {
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

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function addStock(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|numeric',
                'jumlah' => 'required|numeric|min:1',
                'hargamodal' => 'required|numeric|min:1',
                'hargajual' => 'required|numeric|min:1',
                'tanggal_expired' => 'required|date',
            ]);

            $client = new Client();
            $response_product = $client->get($this->baseApiUrl . '/listdaftarproduk');

            if ($response_product->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil data produk dari API');
            }

            $products = json_decode($response_product->getBody()->getContents(), true);

            $productId = $request->input('product_id');
            $product = collect($products)->firstWhere('product_id', $productId);

            if (!$product) {
                throw new \Exception('Produk tidak ditemukan dalam database eksternal');
            }

            $stock = new Stock();
            $stock->product_id = $productId;
            $stock->merchant_id = $request->merchant_id;
            $stock->jumlah_stok = $request->jumlah;
            $stock->spesifikasi = $request->spesifikasi;
            $stock->sisa_stok = $request->jumlah;
            $stock->hargamodal = $request->hargamodal;
            $stock->hargajual = $request->hargajual;
            $stock->tanggal_masuk = now();
            $stock->tanggal_expired = $request->tanggal_expired;
            $stock->lokasi = $request->lokasi;
            $stock->save();

            $response_marketplace_previous = $client->get($this->baseApiUrl . '/getstock/' . $productId, [
                'verify' => true,
            ]);
            
            if ($response_marketplace_previous->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil stok produk dari marketplace');
            }
            
            $stock_previous = json_decode($response_marketplace_previous->getBody()->getContents(), true);
            
            $new_stock = $stock_previous['stok'] + $request->jumlah;
            
            $response_marketplace = $client->post($this->baseApiUrl . '/updatestock', [
                'form_params' => [
                    'product_id' => $productId,
                    'stok' => $new_stock,
                ],
                'verify' => true,
            ]);

            if ($response_marketplace->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengupdate stok di marketplace');
            }

            return response()->json(['message' => 'Stok berhasil ditambahkan dan diupdate di marketplace'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $jumlahStok = $stock->jumlah_stok;
            $stock->delete();

            $client = new Client();
            $response_marketplace_previous = $client->get($this->baseApiUrl . '/getstock/' . $stock->product_id, [
                'verify' => true,
            ]);
            
            if ($response_marketplace_previous->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengambil stok sebelumnya dari marketplace');
            }
            
            $stock_previous = json_decode($response_marketplace_previous->getBody()->getContents(), true);
            
            $new_stock = $stock_previous['stok'] - $jumlahStok;

            $response_marketplace = $client->post($this->baseApiUrl . '/updatestock', [
                'form_params' => [
                    'product_id' => $stock->product_id,
                    'stok' => $new_stock,
                ],
                'verify' => true,
            ]);

            if ($response_marketplace->getStatusCode() !== 200) {
                throw new \Exception('Gagal mengupdate stok di marketplace');
            }

            return response()->json(['message' => 'Stok berhasil dihapus dan diupdate di marketplace'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Stok tidak ditemukan', 'details' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus stok', 'details' => $e->getMessage()], 500);
        }
    }
    
    public function LaporanStok()
    {
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
    
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $stock = Stock::with(['merchant'])->findOrFail($id);

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

            $product = $productMap->get($stock->product_id);
            $categoryId = $product['category_id'] ?? null;
            $categoryName = $categoryMap->get($categoryId)['nama_kategori'] ?? 'Kategori Tidak Ditemukan';

            $data = [
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

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sisa_stok' => 'required|numeric|min:1',
            'tanggal_expired' => 'required|date',
        ]);
        $stock = Stock::findOrFail($id);

        if ($stock) {
            $stock->sisa_stok = $request->sisa_stok;
            $stock->tanggal_expired = $request->tanggal_expired;
            $stock->save();

            return response()->json(['message' => 'Stok berhasil diupdate']);
        } else {
            return response()->json(['message' => 'Stok tidak ditemukan'], 404);
        }
    }
}




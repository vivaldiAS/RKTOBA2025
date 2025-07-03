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

class ProdukWarehouseController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function produkwarehouse()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
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
                
                        return view('admin.warehouse.produk_warehouse', ['data' => $data]);
                    } catch (\Exception $e) {
                        return view('admin.warehouse.produk_warehouse', ['error' => $e->getMessage()]);
                    }
                } catch (\Exception $e) {
                    return view('admin.warehouse.produk_warehouse')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }

    public function pembelianproduk()
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
                    return view('admin.warehouse.pembelian_produk', compact('purchases'));
                } catch (\Exception $e) {
                    return view('admin.warehouse.pembelian_produk')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }
    
    public function tambahproduk()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {      
                    $merchants = Merchants::all();
                    $categories = Category::all();
                    $products = Product::all();
                    return view('admin.warehouse.tambah_produk', compact('merchants', 'categories', 'products'));

                } catch (\Exception $e) {
                    return view('admin.warehouse.produk_warehouse')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }

    public function addStock(Request $request)
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    $request->validate([
                        'namaToko' => 'required|exists:merchants,merchant_id',
                        'kategoriProduk' => 'required|exists:categories,category_id',
                        'namaProduk' => 'required|exists:products,product_id',
                        'spesifikasi' => 'required|string|max:255',
                        'lokasi' => 'required|string|max:255',
                        'jumlah' => 'required|integer|min:1',
                        'hargamodal' => 'required|numeric|min:0',
                        'hargajual' => 'required|numeric|min:0',
                        'tanggalExpired' => 'required|date',
                    ]);
            
                    try {
                        $stock = new Stock();
                        $stock->product_id = $request->namaProduk;
                        $stock->merchant_id = $request->namaToko;
                        $stock->jumlah_stok = $request->jumlah;
                        $stock->sisa_stok = $request->jumlah;
                        $stock->spesifikasi = $request->spesifikasi;
                        $stock->hargamodal = $request->hargamodal;
                        $stock->hargajual = $request->hargajual;
                        $stock->tanggal_masuk = now();
                        $stock->tanggal_expired = $request->tanggalExpired;
                        $stock->lokasi = $request->lokasi;
                        $stock->save();
            
                        return redirect()->route('admin.produk.warehouse')->with('success', 'Stok berhasil ditambahkan');
                    } catch (\Exception $e) {
                        return redirect()->back()->with('error', 'Gagal menambahkan stok: ' . $e->getMessage());
                    }
                } catch (\Exception $e) {
                    return view('admin.warehouse.produk_warehouse')->withErrors($e->getMessage());
                }
            } else {
                return redirect('/home')->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        } else {
            return redirect('/login');
        }
    }

    public function editProduk($id)
    {
        $stock = Stock::with(['merchant'])->findOrFail($id);
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
            
            if ($cek_admin_id) {
                try {
                    try {
                        $merchants = Merchants::all();
                        $categories = Category::all();
                        $products = Product::all();
                        return view('admin.warehouse.edit_produk', compact('stock','merchants','categories','products'));
                    } catch (\Exception $e) {
                        return response()->json(['error' => $e->getMessage()], 500);
                    }
                } catch (\Exception $e) {
                    return view('admin.warehouse.produk_warehouse')->withErrors($e->getMessage());
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
    
            return redirect()->route('admin.produk.warehouse')->with('success', 'Produk berhasil diperbarui');

        } catch (\Exception $e) {
            return view('admin.warehouse.produk_warehouse')->withErrors($e->getMessage());
        }
    }

    public function hapusProduk($id)
    {
        try {
            $stock = Stock::findOrFail($id);
            $stock->delete();

            return redirect()->route('admin.warehouse.produk_warehouse');

        } catch (\Exception $e) {
            return view('admin.warehouse.index')->withErrors($e->getMessage());
        }
    }
}

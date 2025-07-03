<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Merchants;
use App\Models\Category;
use App\Models\Transaksi;
use App\Models\StokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiWarehouseController extends Controller
{
    private $baseApiUrl;

    public function __construct()
    {
        $this->baseApiUrl = 'https://kreatif.tobakab.go.id/api';
    }

    public function transaksiwarehouse() 
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            // Jika pengguna adalah admin
            if ($cek_admin_id) {
                try {
                    
                    $client = new Client();
                    $response = $client->get($this->baseApiUrl . '/listdaftarproduk');
                
                    if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                        $products = json_decode($response->getBody()->getContents(), true);
                        $productMap = [];
                
                        foreach ($products as $product) {
                            $productMap[$product['product_id']] = $product['product_name'];
                        }
                
                        $transaksis = Transaksi::select(
                            'transaksi.transaksi_id',
                            'stocks_warehouse.product_id',
                            'merchants.nama_merchant',
                            'transaksi.penanggung_jawab',
                            'transaksi.jumlah_barang_keluar',
                            'transaksi.tanggal_keluar',

                        )
                        ->join('stocks_warehouse', 'transaksi.stock_id', '=', 'stocks_warehouse.stock_id')
                        ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
                        ->orderBy('transaksi.tanggal_keluar', 'desc') 
                        ->get();
                
                        foreach ($transaksis as $transaksi) {
                            $transaksi->product_name = $productMap[$transaksi->product_id] ?? 'Unknown Product';
                        }
                        
                        return view('admin.warehouse.transaksi_warehouse', compact('transaksis'));
                
                    } else {
                        return view('admin.warehouse.transaksi_warehouse')->withErrors('Failed to fetch products from external API');
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

    public function tambahtransaksi()
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    $transaksi = Transaksi::all();
                    $products = Stock::with(['merchant'])
                            ->where('sisa_stok', '>', 0)
                            ->get();
                    return view('admin.warehouse.tambah_transaksi', compact('transaksi','products'));

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

    public function addTransaksi(Request $request)
    {
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    try {
                        DB::beginTransaction();
                
                        $stock = Stock::where('stock_id', $request->stock_id)->first();
                        
                        if (!$stock) {
                            return redirect()->back()->withErrors('Stok tidak ditemukan.');
                        }
                
                        if ($stock->sisa_stok < $request->jumlah_barang_keluar) {
                            return redirect()->back()->withErrors('Jumlah stok tidak mencukupi.');
                        }
                
                        $stock->sisa_stok -= $request->jumlah_barang_keluar;
                        $stock->save();
                
                        $transaksi = new Transaksi();
                        $transaksi->stock_id = $request->stock_id;
                        $transaksi->penanggung_jawab = $request->penanggung_jawab;
                        $transaksi->jumlah_barang_keluar = $request->jumlah_barang_keluar;
                        $transaksi->tanggal_keluar = $request->tanggal_keluar;
                        $transaksi->save();
                
                        DB::commit();
                        return redirect()->route('admin.transaksiwarehouse.warehouse')->with('success', 'Data berhasil ditambahkan.');
                        
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return redirect()->back()->withErrors($e->getMessage());
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

    public function deleteTransaksi($id)
    {   
        try {

            $transaksi = Transaksi::findOrFail($id);
            $transaksi->delete();
            return redirect()->route('admin.transaksiwarehouse.warehouse');

        } catch (\Exception $e) {
            return view('admin.warehouse.index')->withErrors($e->getMessage());
        }
    }

    public function editTransaksi($id)
    {
        $transaksi = Transaksi::select(
            'transaksi.transaksi_id',
            'transaksi.stock_id',
            'products.product_name',
            'products.product_id',
            'merchants.nama_merchant',
            'transaksi.penanggung_jawab',
            'transaksi.jumlah_barang_keluar',
            DB::raw("DATE_FORMAT(transaksi.tanggal_keluar, '%Y-%m-%d') as tanggal_keluar")
        )
        ->join('stocks_warehouse', 'transaksi.stock_id', '=', 'stocks_warehouse.stock_id')
        ->join('products', 'stocks_warehouse.product_id', '=', 'products.product_id')
        ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
        ->where('transaksi.transaksi_id', $id)
        ->first();

        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    try {
                        if (!$transaksi) {
                            return response()->json(['error' => 'Transaksi tidak ditemukan'], 404);
                        }
            
                        $products = Stock::with('product')->get();
            
                        return view('admin.warehouse.edit_transaksi', compact('transaksi', 'products'));
                        
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

    public function updateTransaksi(Request $request, $id)
    {
        try {
            $request->validate([
                'stock_id' => 'required|exists:stocks_warehouse,stock_id',
                'penanggung_jawab' => 'required|string|max:255',
                'jumlah_barang_keluar' => 'required|integer|min:1',
                'tanggal_keluar' => 'required|date',
            ]);
    
            try {
                $transaksi = Transaksi::findOrFail($id);
                $transaksi->stock_id = $request->input('stock_id');
                $transaksi->penanggung_jawab = $request->input('penanggung_jawab');
                $transaksi->jumlah_barang_keluar = $request->input('jumlah_barang_keluar');
                $transaksi->tanggal_keluar = $request->input('tanggal_keluar');
                $transaksi->save();
    
                return redirect()->route('admin.transaksiwarehouse.warehouse')->with('success', 'Transaksi berhasil diupdate.');
    
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate transaksi: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return view('admin.warehouse.index')->withErrors($e->getMessage());
        }
    }

    public function stokOpname(){
        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    
                    $client = new Client();
                    $response = $client->get($this->baseApiUrl . '/listdaftarproduk');
                
                    if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                        $products = json_decode($response->getBody()->getContents(), true);
                        $productMap = [];
                
                        foreach ($products as $product) {
                            $productMap[$product['product_id']] = $product['product_name'];
                        }
                
                        $stock_opname = StokOpname::select(
                            'stock_opname.id',
                            'stocks_warehouse.product_id',
                            'merchants.nama_merchant',
                            'stock_opname.penanggung_jawab',
                            'stock_opname.jumlah_barang',
                            'stock_opname.tanggal_keluar',
                            'stock_opname.keterangan'
                        )
                        ->join('stocks_warehouse', 'stock_opname.stock_id', '=', 'stocks_warehouse.stock_id')
                        ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
                        ->orderBy('stock_opname.tanggal_keluar', 'desc') 
                        ->get();
                
                        foreach ($stock_opname as $stock_opnames) {
                            $stock_opnames->product_name = $productMap[$stock_opnames->product_id] ?? 'Unknown Product';
                        }
                        
                        return view('admin.warehouse.stok_opname', compact('stock_opname'));
                
                    } else {
                        return view('admin.warehouse.stock_opname')->withErrors('Failed to fetch products from external API');
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

    public function TambahstokOpname(){
        $stok_opname = StokOpname::all();
        $products = Stock::with(['merchant'])
            ->where('sisa_stok', '>', 0)
            ->get();
        return view('admin.warehouse.tambah_stok_opname', compact('stok_opname','products'));
    }

    public function addStockOpname(Request $request){
        DB::beginTransaction();
                
        $stock = Stock::where('stock_id', $request->stock_id)->first();
        
        if (!$stock) {
            return redirect()->back()->withErrors('Stok tidak ditemukan.');
        }

        if ($stock->sisa_stok < $request->jumlah_barang) {
            return redirect()->back()->withErrors('Jumlah stok tidak mencukupi.');
        }

        $stock->sisa_stok -= $request->jumlah_barang;
        $stock->save();

        $stok_opname = new StokOpname();
        $stok_opname->stock_id = $request->stock_id;
        $stok_opname->penanggung_jawab = $request->penanggung_jawab;
        $stok_opname->jumlah_barang = $request->jumlah_barang;
        $stok_opname->tanggal_keluar = $request->tanggal_keluar;
        $stok_opname->keterangan = $request->keterangan;
        $stok_opname->save();

        DB::commit();
        return redirect()->route('admin.stokopname.warehouse')->with('success', 'Data berhasil ditambahkan.');
        
    }

    public function editStokOpname($id)
    {
        $stock_opname = StokOpname::select(
            'stock_opname.id',
            'stock_opname.stock_id',
            'products.product_name',
            'products.product_id',
            'merchants.nama_merchant',
            'stock_opname.penanggung_jawab',
            'stock_opname.jumlah_barang',
            'stock_opname.keterangan',
            DB::raw("DATE_FORMAT(stock_opname.tanggal_keluar, '%Y-%m-%d') as tanggal_keluar")
        )
        ->join('stocks_warehouse', 'stock_opname.stock_id', '=', 'stocks_warehouse.stock_id')
        ->join('products', 'stocks_warehouse.product_id', '=', 'products.product_id')
        ->join('merchants', 'stocks_warehouse.merchant_id', '=', 'merchants.merchant_id')
        ->where('stock_opname.id', $id)
        ->first();

        if (Auth::check()) {
            $id = Auth::user()->id;
            $cek_admin_id = DB::table('users')->where('id', $id)->where('is_admin', 1)->first();
    
            if ($cek_admin_id) {
                try {
                    try {
                        if (!$stock_opname) {
                            return response()->json(['error' => 'Data tidak ditemukan'], 404);
                        }
            
                        $products = Stock::with('product')->get();
            
                        return view('admin.warehouse.edit_stokopname', compact('stock_opname', 'products'));
                        
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

    public function updateStokOpname(Request $request, $id)
    {
        try {
            $request->validate([
                'stock_id' => 'required|exists:stocks_warehouse,stock_id',
                'penanggung_jawab' => 'required|string|max:255',
                'jumlah_barang' => 'required|integer|min:1',
                'tanggal_keluar' => 'required|date',
                'keterangan' => 'required',
            ]);
    
            try {
                $stock_opname = StokOpname::findOrFail($id);
                $stock_opname->stock_id = $request->input('stock_id');
                $stock_opname->penanggung_jawab = $request->input('penanggung_jawab');
                $stock_opname->jumlah_barang = $request->input('jumlah_barang');
                $stock_opname->tanggal_keluar = $request->input('tanggal_keluar');
                $stock_opname->keterangan = $request->input('keterangan');
                $stock_opname->save();
    
                return redirect()->route('admin.stokopname.warehouse')->with('success', 'Transaksi berhasil diupdate.');
    
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupdate transaksi: ' . $e->getMessage());
            }
        } catch (\Exception $e) {
            return view('admin.warehouse.index')->withErrors($e->getMessage());
        }
    }

    public function deleteStokOpname($id)
    {   
        $stock_opname = StokOpname::findOrFail($id);
        $stock_opname->delete();
        return redirect()->route('admin.deleteStokOpname.warehouse');
    }
}

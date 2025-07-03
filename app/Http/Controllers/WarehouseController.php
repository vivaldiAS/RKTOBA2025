<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $merchant = $user->merchant;
    
        $products = Product::where('merchant_id', $merchant->merchant_id)
            ->with(['category', 'stocks.transaksi'])
            ->get();
    
         $totalProducts = $products->reduce(function ($carry, $product) {
                return $carry + $product->stocks->sum('sisa_stok');
            }, 0);
    
        $totalSoldProducts = 0;
        foreach ($products as $product) {
            foreach ($product->stocks as $stock) {
                $totalSoldProducts += $stock->transaksi->sum('jumlah_barang_keluar');
            }
        }

        $categories = $products->groupBy('category_id')->count();

        $produk = $products ->filter(function ($product) {
                return $product->stocks->sum('sisa_stok')>0;
            })->values();
    
        return view('user.toko.warehouse.index', compact('products','produk', 'totalProducts', 'totalSoldProducts', 'categories'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('user.toko.warehouse.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWarehouseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)    
    {
        $input = $request->validated();

        $image = $request->file('upload_image');

        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images'), $imageName);

        Warehouse::create(
            [
                'merchant_id' => auth()->user()->merchant->merchant_id,
                'category_id' => $input['jenis_produk'],
                'user_id' => auth()->user()->id,
                'product_name' => $input['nama_produk'],
                'product_description' => $input['deskripsi_produk'],
                'image' => $imageName,
                'price' => $input['harga'],
                'heavy' => $input['berat'],
                'stok' => $input['jumlah'],
                'expired_at' => Carbon::createFromFormat('Y-m-d h:i:s', date('Y-m-d h:i:s', strtotime($input['expired_date'])))->format('Y-m-d h:i:s'),
                'is_request' => 1,
                'is_accepted' => 0,
                'alasan_ditolak' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia eligendi deleniti cum tempore. Ipsa laudantium architecto perspiciatis cupiditate, rerum omnis temporibus non. Ducimus beatae deleniti, hic esse dignissimos recusandae maxime!',
                'in_gallery' => 0,
                'is_deleted' => 0,
            ]
        );

        return redirect()->route('warehouse.index')->with('status', 'Success menambah request');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWarehouseRequest  $request
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }

    public function warehouseListAPI()
    {
        $warehouse = Warehouse::where('is_accepted', 1)->paginate(10)->withQueryString();

        return response()->json($warehouse);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function produkByToken(Request $request)
{
    // Ambil user yang sudah terautentikasi via sanctum
    $user = $request->user();

    // Cari merchant_id berdasarkan user_id yang sudah login
    $toko = DB::table('merchants')
        ->where('user_id', $user->id)
        ->value('merchant_id');

    // Ambil produk berdasarkan merchant_id, non deleted, join stocks & categories
    $products = DB::table('products')
        ->where('merchant_id', $toko)
        ->where('is_deleted', 0)
        ->orderBy('products.product_id', 'desc')
        ->join('stocks', 'stocks.product_id', '=', 'products.product_id')
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->get();

    return response()->json($products);
}
public function index()
{
    $produk_makanan_minuman_terlaris = DB::table('product_purchases')
        ->select(
            DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name',
            DB::raw('COALESCE(ROUND(AVG(reviews.nilai_review), 1), 0) as average_rating')
        )
        ->where('is_deleted', 0)
        ->where(function ($query) {
            $query->where('products.category_id', 1)
                ->orWhere('products.category_id', 7);
        })
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->leftJoin('reviews', 'reviews.product_id', '=', 'products.product_id')
        ->groupBy(
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name'
        )
        ->orderBy('count_product_purchases', 'desc')
        ->limit(20)->get();

    $produk_pakaian_terlaris = DB::table('product_purchases')
        ->select(
            DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name',
            DB::raw('COALESCE(ROUND(AVG(reviews.nilai_review), 1), 0) as average_rating')
        )
        ->where('is_deleted', 0)
        ->where('products.category_id', 2)
        ->join('products', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->leftJoin('reviews', 'reviews.product_id', '=', 'products.product_id')
        ->groupBy(
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name'
        )
        ->orderBy('count_product_purchases', 'desc')
        ->limit(20)->get();

    $new_products = DB::table('products')
        ->select(
            'products.product_id',
            'products.product_name',
            'products.category_id',
            'products.price',
            'products.merchant_id',
            'products.product_description',
            'products.heavy',
            'products.type',
            'categories.nama_kategori',
            'merchants.nama_merchant',
            'merchant_address.subdistrict_name',
            DB::raw('COALESCE(ROUND(AVG(reviews.nilai_review), 1), 0) as average_rating')
        )
        ->where('is_deleted', 0)
        ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->leftJoin('reviews', 'reviews.product_id', '=', 'products.product_id')
        ->groupBy(
            'products.product_id',
            'products.product_name',
            'products.category_id',
            'products.price',
            'products.merchant_id',
            'products.product_description',
            'products.heavy',
            'products.type',
            'categories.nama_kategori',
            'merchants.nama_merchant',
            'merchant_address.subdistrict_name'
        )
        ->orderBy('products.product_id', 'desc')
        ->limit(20)->get();

    $products = DB::table('products')
        ->select(
            'products.product_id',
            'products.product_name',
            'products.category_id',
            'products.price',
            'products.merchant_id',
            'products.product_description',
            'products.heavy',
            'products.type',
            'categories.nama_kategori',
            'merchants.nama_merchant',
            'merchant_address.subdistrict_name',
            DB::raw('COALESCE(ROUND(AVG(reviews.nilai_review), 1), 0) as average_rating')
        )
        ->where('is_deleted', 0)
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        ->join('stocks', 'stocks.product_id', '=', 'products.product_id')
        ->leftJoin('reviews', 'reviews.product_id', '=', 'products.product_id')
        ->groupBy(
            'products.product_id',
            'products.product_name',
            'products.category_id',
            'products.price',
            'products.merchant_id',
            'products.product_description',
            'products.heavy',
            'products.type',
            'categories.nama_kategori',
            'merchants.nama_merchant',
            'merchant_address.subdistrict_name'
        )
        ->inRandomOrder()->get();

    $product_images = DB::table('product_images')
        ->select('product_id', DB::raw('MIN(product_image_name) AS product_image_name'))
        ->groupBy('product_id')
        ->orderBy('product_id', 'asc')->get();

    return response()->json([
        'produk_makanan_minuman_terlaris' => $produk_makanan_minuman_terlaris,
        'produk_pakaian_terlaris' => $produk_pakaian_terlaris,
        'new_products' => $new_products,
        'products' => $products,
        'product_images' => $product_images
    ]);
}

    
    public function produk_detail(Request $request)
    {
        $products = DB::table('products')->where('is_deleted', 0)->where('products.product_id', $request->product_id)
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('product_images', 'product_images.product_id', '=', 'products.product_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            ->join('stocks', 'stocks.product_id', '=', 'products.product_id')
            ->get();

        return response()->json(
            $products
        );
    }

public function lihat_produk(Request $request)
{
    $validasi = Validator::make($request->all(), [
        'nama_kategori' => 'required',
    ]);

    if ($validasi->fails()) {
        $val = $validasi->errors()->all();
        return response()->json(['message' => $val[0]], 400);
    }

    $products = DB::table('products')
        ->where('products.is_deleted', 0)
        ->select(
            DB::raw('SUM(jumlah_pembelian_produk) as count_product_purchases'),
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name',
            // Tambahkan gambar pertama dari tabel product_images
            DB::raw('(SELECT product_image_name FROM product_images WHERE product_images.product_id = products.product_id LIMIT 1) as product_image_name')
        )
        ->where('categories.nama_kategori', '=', $request->nama_kategori)
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        ->join('product_purchases', 'product_purchases.product_id', '=', 'products.product_id')
        ->join('stocks', 'stocks.product_id', '=', 'products.product_id')
        ->groupBy(
            'product_purchases.product_id',
            'products.product_name',
            'products.category_id',
            'categories.nama_kategori',
            'products.merchant_id',
            'merchants.nama_merchant',
            'products.price',
            'merchant_address.subdistrict_name',
            'products.product_id'
        )
        ->inRandomOrder()
        ->get();

    return response()->json($products, 200);
}



    public function pilih_kategori()
    {
        $categories = DB::table('categories')->orderBy('nama_kategori', 'asc')->get();

        return response()->json(
            $categories
        );
    }


    public function PostTambahProduk(Request $request)
    {
        $toko = DB::table('merchants')->where('user_id', $request->user_id)->value('merchant_id');
        $product_name = $request->product_name;
        $product_description = $request->product_description;
        $price = $request->price;
        $heavy = $request->heavy;
        $kategori_produk_id = DB::table('categories')->where('nama_kategori', $request->kategori)->value('category_id');

        // $product_image = $request->file('product_image');
        // $jumlah_product_image = count($product_image);

        $stok = $request->stok;

        $product_id = DB::table('products')->insertGetId([
            'merchant_id' => $toko,
            'category_id' => $kategori_produk_id,
            'product_name' => $product_name,
            'product_description' => $product_description,
            'price' => $price,
            'heavy' => $heavy,
            'is_deleted' => 0,
        ]);


        // if ($specification_id) {
        //     $jumlah_specification_id_dipilih = count($specification_id);

        //     for ($x = 0; $x < $jumlah_specification_id_dipilih; $x++) {
        //         DB::table('product_specifications')->insert([
        //             'product_id' => $product_id,
        //             'specification_id' => $specification_id[$x],
        //         ]);
        //     }
        // }

        foreach ($request->file('product_image') as $product_image) {
            $nama_product_image = time() . '_' . $product_image->getClientOriginalName();
            $tujuan_upload = './asset/u_file/product_image';
            $product_image->move($tujuan_upload, $nama_product_image);

            DB::table('product_images')->insert([
                'product_id' => $product_id,
                'product_image_name' => $nama_product_image,
            ]);
        }

        DB::table('stocks')->insert([
            'product_id' => $product_id,
            'stok' => $stok,
        ]);

        return response()->json(
            200
        );
    }

    public function produk(Request $request)
    {
        $toko = DB::table('merchants')
        ->where('user_id', $request->user_id)
        ->value('merchant_id');
        $products = DB::table('products')
            ->where('merchant_id', $toko)
            ->where('is_deleted', 0)
            ->orderBy('products.product_id', 'desc')
            ->join('stocks', 'stocks.product_id', '=', 'products.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')->get();

        return response()->json(
            $products
        );
    }

    public function hapusProduk(Request $request)
    {
        DB::table('products')->where('product_id', $request->product_id)->update([
            'is_deleted' => 1,
        ]);

        return response()->json(
            200
        );
    }

    public function editProduk(Request $request)
    {
        $product_id = $request->product_id;
        $product_name = $request->product_name;
        $product_description = $request->product_description;
        $price = $request->price;
        $heavy = $request->heavy;
        $kategori_produk_id = DB::table('categories')->where('nama_kategori', $request->kategori_produk_id)->value('category_id');

        $product_image = $request->file('product_image');

        $stok = $request->stok;

        if (!$product_image) {
            DB::table('products')->where('product_id', $product_id)->update([
                'product_name' => $product_name,
                'product_description' => $product_description,
                'price' => $price,
                'heavy' => $heavy,
                'category_id' =>  $kategori_produk_id
            ]);

            DB::table('stocks')->where('product_id', $product_id)->update([
                'stok' => $stok,
            ]);
        }else {
            $jumlah_product_image = count($product_image);
            $products_lama = DB::table('product_images')->where('product_id', $product_id)->get();
            $asal_gambar = 'asset/u_file/product_image/';
            foreach ($products_lama as $products_lama) {
                $product_image_lama = public_path($asal_gambar . $products_lama->product_image_name);
                if (File::exists($product_image_lama)) {
                    File::delete($product_image_lama);
                }
            }

            DB::table('product_images')->where('product_id', $product_id)->delete();

            DB::table('products')->where('product_id', $product_id)->update([
                'product_name' => $product_name,
                'product_description' => $product_description,
                'price' => $price,
                'heavy' => $heavy,
                'category_id' =>  $kategori_produk_id
            ]);

            for ($x = 0; $x < $jumlah_product_image; $x++) {
                $nama_product_image[$x] = time() . '_' . $product_image[$x]->getClientOriginalName();
                $tujuan_upload = './asset/u_file/product_image';
                $product_image[$x]->move($tujuan_upload, $nama_product_image[$x]);

                DB::table('product_images')->insert([
                    'product_id' => $product_id,
                    'product_image_name' => $nama_product_image[$x],
                ]);
            }

            DB::table('stocks')->where('product_id', $product_id)->update([
                'stok' => $stok,
            ]);
        }
        return response()->json(
            200
        );
    }

    public function daftarproduk()
    {
        $banks = DB::table('products')->orderBy('product_name', 'asc')->get();
        return response()->json(
            $banks
        );
    }

    public function getStock($productId)
    {
        try {
            if (!is_numeric($productId) || intval($productId) <= 0) {
                throw new \Exception('Product ID is invalid');
            }
            
            $stock = DB::table('stocks')->where('product_id', $productId)->first();
            
            if (!$stock) {
                return response()->json(['error' => 'Stock not found'], 404);
            }
            
            return response()->json($stock);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStock(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|numeric',
                'stok' => 'required|numeric',
            ]);

            $product = DB::table('products')->where('product_id', $request->input('product_id'))->first();

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            DB::table('stocks')
                ->where('product_id', $request->input('product_id'))
                ->update(['stok' => $request->input('stok')]);

            return response()->json(['message' => 'Stock updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
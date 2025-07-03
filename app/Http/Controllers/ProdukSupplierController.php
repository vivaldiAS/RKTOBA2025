<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ProdukSupplierController extends Controller
{
    /**
     * Menampilkan halaman daftar seluruh produk.
     */

    public function produksupplier(Request $request)
    {
        $toko = Session::get('toko');

        $toko_ditemukan = -1;

        $produk_ditemukan = -1;

        $more_data = 0;

        if ($toko) {
            $products = DB::table('products')->where('products.merchant_id', $toko)
            ->where('is_deleted', 0)->orderBy('product_id', 'desc')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where('categories.type', 'supplier')
            ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->get();

            // $products = DB::table('products')
            //     ->where('products.merchant_id', $toko)
            //     ->where('is_deleted', 0)
            //     ->orderBy('products.product_id', 'desc')
            //     ->select(
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     // ->join("product_purchases", "products.product_id", "=", "product_purchases.product_id")
            //     ->join('categories', 'products.category_id','=','categories.category_id')
            //     ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            //     ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            //     ->groupBy(
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->get();
            return view('user.toko.produksupplier')->with('products', $products);
        }

        elseif (!$toko) {
            $kategori_produk_id = 0;

            $products = DB::table('products')->where('is_deleted', 0)
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where('categories.type', 'supplier')
            ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->inRandomOrder()->get();

            // $products = DB::table('products')
            //     ->where('is_deleted', 0)
            //     ->select(
            //         DB::raw('COUNT(*) as total_terjual'),
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->join("product_purchases", "products.product_id", "=", "product_purchases.product_id")
            //     ->join('categories', 'products.category_id','=','categories.category_id')
            //     ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            //     ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            //     ->inRandomOrder()
            //     ->groupBy(
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->get();

            $categories = Category::with('subcategory')->where('type', 'supplier')->orderBy('nama_kategori', 'asc')->get();
            $sub_categories = DB::table('sub_categories')->orderBy('nama_sub_kategori', 'asc')->join('categories', 'categories.category_id', '=', 'sub_categories.category_id')->get();

            // $nama_kategori = DB::table('categories')->where('category_id', $kategori_produk_id)->first();

            return view('user.produksupplier')->with('toko_ditemukan', $toko_ditemukan)->with('produk_ditemukan', $produk_ditemukan)->with('products', $products)->with('categories', $categories)->with('sub_categories', $sub_categories)
            ->with('kategori_produk_id', $kategori_produk_id);
        }
    }

    public function jasa_kreatif() {
        $toko = Session::get('toko');

        $services = DB::table('services')->where('merchant_id', $toko)->where('is_deleted', 0)->orderBy('service_id', 'desc')
        ->join('sub_categories', 'services.sub_category_id', '=', 'sub_categories.id')->get();

        return view('user.toko.jasa_kreatif')->with('services', $services);
    }

    public function cari_produksupplier(Request $request)
    {
        $cari = $request->cari;

        return redirect("./cari_produksupplier/$cari");
    }

    public function jasa_kreatif_kategori($sub_kategori_produk_id)
    {
        $toko = Session::get('toko');

        $toko_ditemukan = -1;

        $produk_ditemukan = -1;

        if($toko){
            // $products = DB::table('products')->where('merchant_id', $toko)->orderBy('product_id', 'desc')
            // ->join('categories', 'products.category_id', '=', 'categories.category_id')->get();

            // return view('user.toko.produk')->with('products', $products);
        }

        else{
            $services = DB::table('services')->where('services.sub_category_id', $sub_kategori_produk_id)->where('is_deleted', 0)
            ->join('sub_categories', 'services.sub_category_id', '=', 'sub_categories.sub_category_id')
            ->join('merchants', 'services.merchant_id', '=', 'merchants.merchant_id')->inRandomOrder()->get();

            $service_info = DB::table('services')->orderBy('service_id', 'desc')->join('sub_categories', 'services.sub_category_id', '=', 'sub_categories.sub_category_id')
            ->join('merchants', 'service.merchant_id', '=', 'merchants.merchant_id')->first();

            $sub_categories = Category::with('subcategory')->get();

            $nama_sub_kategori = DB::table('sub_categories')->where('sub_category_id', $sub_kategori_produk_id)->first();

            return view('user.jasa_kreatif')->with('toko_ditemukan', $toko_ditemukan)->with('produk_ditemukan', $produk_ditemukan)->with('services', $services)->with('sub_categories', $sub_categories)
            ->with('sub_kategori_produk_id', $sub_kategori_produk_id)->with('nama_sub_kategori', $nama_sub_kategori);
        }
    }

    public function cari_view_produk_supplier(Request $request)
    {
        $cari = $request->cari;

        $kategori_produk_id = 0;

        $toko_ditemukan = DB::table('merchants')
            ->where('nama_merchant', 'like', "%" . $cari . "%")
            ->count();

        $toko = DB::table('merchants')
            ->where('nama_merchant', 'like', "%" . $cari . "%")
            ->orderBy('nama_merchant', 'asc')
            ->get();

        $produk_ditemukan = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            ->where('is_deleted', 0)
            ->where('type', 'supplier')
            ->where('product_name', 'like', "%" . $cari . "%")
            ->count();


        $products = DB::table('products')
        ->join('categories', 'products.category_id', '=', 'categories.category_id')
        ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
        ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
        ->where('is_deleted', 0)
        ->where('type', 'supplier')
        ->where('product_name', 'like',"%".$cari."%")
        ->inRandomOrder()->get();

        // $products = DB::table('products')
        //     ->select(
        //         DB::raw('COUNT(*) as total_terjual'),
        //         "products.*",
        //         'products.product_name',
        //         'products.category_id',
        //         'nama_kategori',
        //         'products.merchant_id',
        //         'nama_merchant',
        //         'products.price',
        //         'city_name',
        //         'subdistrict_name',
        //         'province_name'
        //     )
        //     ->join(
        //         'categories',
        //         'products.category_id',
        //         '=',
        //         'categories.category_id'
        //     )
        //     ->join(
        //         'merchants',
        //         'products.merchant_id',
        //         '=',
        //         'merchants.merchant_id'
        //     )
        //     ->join("product_purchases", "product_purchases.product_id", "=", "products.product_id")
        //     ->groupBy(
        //         'products.product_id',
        //         'products.product_name',
        //         'products.category_id',
        //         'nama_kategori',
        //         'products.merchant_id',
        //         'nama_merchant',
        //         'products.price',
        //         'city_name',
        //         'subdistrict_name',
        //         'province_name'
        //     )
        //     ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
        //     ->where('is_deleted', 0)
        //     ->where('product_name', 'like', "%" . $cari . "%")
        //     ->inRandomOrder()
        //     ->get();

        $categories = DB::table('categories')
            ->orderBy('nama_kategori', 'asc')
            ->where('type', 'supplier')
            ->get();

        return view('user.produksupplier')
            ->with('toko_ditemukan', $toko_ditemukan)
            ->with('toko', $toko)
            ->with('produk_ditemukan', $produk_ditemukan)
            ->with('products', $products)
            ->with('categories', $categories)
            ->with('kategori_produk_id', $kategori_produk_id);
    }


    /**
     * Menampilkan halaman daftar produk yang akan menampilkan produk berdasarkan kategorinya.
     */

    public function produk_supplier_kategori($kategori_produk_id)
    {
        $toko = Session::get('toko');

        $toko_ditemukan = -1;

        $produk_ditemukan = -1;

        if ($toko) {

        }

        elseif (!$toko) {
            $products = DB::table('products')
            ->where('products.category_id', $kategori_produk_id)
            ->where('is_deleted', 0)
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where('categories.type', 'supplier')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            ->inRandomOrder()->get();

            // $products = DB::table('products')
            //     ->where('products.category_id', $kategori_produk_id)
            //     ->where('is_deleted', 0)
            //     ->orderBy('product_id', 'desc')
            //     ->select(
            //         'total_terjual',
            //         "products.*",
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->joinSub("SELECT IFNULL(COUNT(product_purchases.product_id), 0) AS total_terjual, products.product_id FROM product_purchases RIGHT JOIN products ON product_purchases.product_id = products.product_id GROUP BY products.product_id", "total", "total.product_id", "=", "products.product_id")
            //     ->join(
            //         'categories',
            //         'products.category_id',
            //         '=',
            //         'categories.category_id'
            //     )
            //     ->join(
            //         'merchants',
            //         'products.merchant_id',
            //         '=',
            //         'merchants.merchant_id'
            //     )
            //     ->join("merchant_address", 'merchant_address.merchant_id', "=", "products.merchant_id")
            //     ->groupBy(
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->get();

            $categories = DB::table('categories')
                ->where('type', 'supplier')
                ->orderBy('nama_kategori', 'asc')
                ->get();

            $nama_kategori = DB::table('categories')
                ->where('type', 'supplier')
                ->where('category_id', $kategori_produk_id)
                ->first();

            return view('user.produksupplier')
                ->with('toko_ditemukan', $toko_ditemukan)
                ->with('produk_ditemukan', $produk_ditemukan)
                ->with('products', $products)
                ->with('categories', $categories)
                ->with('kategori_produk_id', $kategori_produk_id)
                ->with('nama_kategori', $nama_kategori);
        }
    }

    public function pilih_kategori_produk_supplier() {
        $categories = DB::table('categories')->where('type', 'supplier')->where('disabled', False)->orderBy('nama_kategori', 'asc')->get();

        return view('user.toko.pilih_kategori_produk_supplier')->with('categories', $categories);
    }

    public function pilih_jasa_kreatif() {
        $sub_categories = DB::table('sub_categories')->orderBy('nama_sub_kategori', 'asc')->get();

        return view('user.toko.pilih_jasa_kreatif')->with('sub_categories', $sub_categories);
    }

    public function produk_supplier_toko_belanja($merchant_id) {
        $toko = Session::get('toko');

        $toko_ditemukan = -1;

        $produk_ditemukan = -1;

        if ($toko) {

        }

        else {
            $products = DB::table('products')
            ->where('products.merchant_id', $merchant_id)->where('is_deleted', 0)
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->where('categories.type', 'supplier')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')
            ->join("merchant_address", 'products.merchant_id', "=", "merchant_address.merchant_id")
            ->inRandomOrder()->get();

            // $products = DB::table('products')
            //     ->select(
            //         DB::raw('COUNT(*) as total_terjual'),
            //         "products.*",
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->where('products.merchant_id', $merchant_id)
            //     ->where('is_deleted', 0)
            //     ->join(
            //         'categories',
            //         'products.category_id',
            //         '=',
            //         'categories.category_id'
            //     )
            //     ->join(
            //         'merchants',
            //         'products.merchant_id',
            //         '=',
            //         'merchants.merchant_id'
            //     )
            //     ->join("merchant_address", "products.merchant_id", "=", "merchant_address.merchant_id")
            //     ->groupBy(
            //         'products.product_id',
            //         'products.product_name',
            //         'products.category_id',
            //         'nama_kategori',
            //         'products.merchant_id',
            //         'nama_merchant',
            //         'products.price',
            //         'city_name',
            //         'subdistrict_name',
            //         'province_name'
            //     )
            //     ->join("product_purchases", "product_purchases.product_id", "=", "products.product_id")
            //     ->inRandomOrder()
            //     ->get();

            $categories = DB::table('categories')
                ->where('type', 'supplier')
                ->orderBy('nama_kategori', 'asc')
                ->get();

            $kategori_produk_id = 0;

            return view('user.produksupplier')
                ->with('toko_ditemukan', $toko_ditemukan)
                ->with('produk_ditemukan', $produk_ditemukan)
                ->with('products', $products)
                ->with('categories', $categories)
                ->with('merchant_id', $merchant_id)
                ->with('kategori_produk_id', $kategori_produk_id);
        }
    }

    public function tambah_produk_supplier($kategori_produk_id)
    {
        $category_type_specifications = DB::table(
            'category_type_specifications'
        )
            ->join(
                'categories',
                'category_type_specifications.category_id',
                '=',
                'categories.category_id'
            )
            ->join(
                'specification_types',
                'category_type_specifications.specification_type_id',
                '=',
                'specification_types.specification_type_id'
            )
            ->where(
                'category_type_specifications.category_id',
                $kategori_produk_id
            )
            ->orderBy('category_type_specification_id', 'asc')
            ->get();

        $specifications = DB::table('specifications')
            ->orderBy('nama_spesifikasi', 'asc')
            ->get();

        return view('user.toko.tambah_produk_supplier')
            ->with(
                'category_type_specifications',
                $category_type_specifications
            )
            ->with('specifications', $specifications)
            ->with('kategori_produk_id', $kategori_produk_id);
    }

    public function tambah_jasa_kreatif() {
        $sub_categories = DB::table('sub_categories')->orderBy('nama_sub_kategori', 'asc')->get();

        return view('user.toko.tambah_jasa_kreatif')->with('sub_categories', $sub_categories);
    }

//    public function PostTambahProduk(Request $request, $kategori_produk_id) {
        // $request -> validate([
        //     'merchant_id' => 'required',
        //     'product_name' => 'required',
        //     'price' => 'required',
        //     'product_image' => 'required',
        //     'specification_id' => 'required',
        // ]);

    /**
     * Menyimpan penambahan produk ke dalam tabel " products ".
     */

    public function PostTambahProdukSupplier(Request $request, $kategori_produk_id)
    {
        $toko = Session::get('toko');
        $product_name = $request->product_name;
        $product_description = $request->product_description;
        $price = $request->price;
        $heavy = $request->heavy;

        $specification_id = $request->specification_id;

        $product_image = $request->file('product_image');
        $jumlah_product_image = count($product_image);

        $stok = $request->stok;

        DB::table('products')->insert([
            'merchant_id' => $toko,
            'category_id' => $kategori_produk_id,
            'product_name' => $product_name,
            'product_description' => $product_description,
            'price' => $price,
            'heavy' => $heavy,
            'type' => 'supplier',
            'is_deleted' => 0,
        ]);

        $product_id = DB::table('products')->select('product_id')->where('type', 'supplier')->orderBy('product_id', 'desc')->first();

        if ($specification_id) {
            $jumlah_specification_id_dipilih = count($specification_id);

            for ($x = 0; $x < $jumlah_specification_id_dipilih; $x++) {
                DB::table('product_specifications')->insert([
                    'product_id' => $product_id->product_id,
                    'specification_id' => $specification_id[$x],
                ]);
            }
        }

        for ($x = 0; $x < $jumlah_product_image; $x++) {
            $nama_product_image[$x] =
                time() . '_' . $product_image[$x]->getClientOriginalName();
            $tujuan_upload = './asset/u_file/product_image';
            $product_image[$x]->move($tujuan_upload, $nama_product_image[$x]);

            DB::table('product_images')->insert([
                'product_id' => $product_id->product_id,
                'product_image_name' => $nama_product_image[$x],
            ]);
        }

        DB::table('stocks')->insert([
            'product_id' => $product_id->product_id,
            'stok' => $stok,
        ]);

        return redirect('./produksupplier');
    }

    public function PostTambahJasaKreatif(Request $request) {

        $kategori_jasa_kreatif = DB::table('categories')->where('nama_kategori', 'Jasa Kreatif')->first();

        $toko = Session::get('toko');
        $sub_category_id = $request -> sub_category_id;
        $service_name = $request -> service_name;
        $service_description = $request -> service_description;
        $price = $request -> price;
        $service_image = $request -> file('service_image');
        $jumlah_service_image = count($service_image);

        DB::table('services')->insert([
            'merchant_id' => $toko,
            'category_id' => $kategori_jasa_kreatif->category_id,
            'sub_category_id' => $sub_category_id,
            'service_name' => $service_name,
            'service_description' => $service_description,
            'price' => $price,
            'is_deleted' => 0,
        ]);

        $service_id = DB::table('services')->select('service_id')->orderBy('service_id', 'desc')->first();

        for($x=0; $x<$jumlah_service_image; $x++){
            $nama_service_image[$x] = time().'_'.$service_image[$x]->getClientOriginalName();
            $tujuan_upload = './asset/u_file/service_image';
            $service_image[$x]->move($tujuan_upload,$nama_service_image[$x]);

            DB::table('service_images')->insert([
                'service_id' => $service_id->service_id,
                'service_image_name' => $nama_service_image[$x],
            ]);
        }

        return redirect('./jasa_kreatif');
    }

    public function edit_produk_supplier($product_id) {
        $toko = Session::get('toko');

        $product = DB::table('products')
            ->where('products.merchant_id', $toko)
            ->where('product_id', $product_id)
            ->where('is_deleted', 0)
            ->join(
                'categories',
                'products.category_id',
                '=',
                'categories.category_id'
            )
            ->where('categories.type', 'supplier')
            ->join(
                'merchants',
                'products.merchant_id',
                '=',
                'merchants.merchant_id'
            )
            ->first();

        $stock = DB::table('stocks')
            ->where('product_id', $product_id)
            ->first();

        $product_specifications = DB::table('product_specifications')
            ->where('product_id', $product_id)
            ->join(
                'specifications',
                'product_specifications.specification_id',
                '=',
                'specifications.specification_id'
            )
            ->first();

        $jumlah_product_specifications = DB::table('product_specifications')
            ->where('product_id', $product_id)
            ->count();

        $product_images = DB::table('product_images')
            ->where('product_id', $product_id)
            ->get();

        return view('user.toko.edit_produk_supplier')
            ->with('product', $product)
            ->with('product_images', $product_images)
            ->with('stock', $stock)
            ->with('product_id', $product_id)
            ->with('product_specifications', $product_specifications)
            ->with(
                'jumlah_product_specifications',
                $jumlah_product_specifications
            );
    }

    public function edit_jasa_kreatif($service_id) {
        $toko = Session::get('toko');

        $service = DB::table('services')->where('services.merchant_id', $toko)->where('service_id', $service_id)->where('is_deleted', 0)
        ->join('sub_categories', 'services.sub_category_id', '=', 'sub_categories.id')->join('merchants', 'services.merchant_id', '=', 'merchants.merchant_id')->first();

        $sub_categories = DB::table('sub_categories')->orderBy('nama_sub_kategori', 'asc')->get();

        $service_images = DB::table('service_images')->where('service_id', $service_id)->get();

        return view('user.toko.edit_jasa_kreatif')->with('service', $service)->with('service_images', $service_images)->with('sub_categories', $sub_categories)
        ->with('service_id', $service_id);
    }

    /**
     * Menyimpan perubahan produk ke dalam tabel " products ".
     */

    public function PostEditProdukSupplier(Request $request, $product_id)
    {
        $product_name = $request->product_name;
        $product_description = $request->product_description;
        $price = $request->price;
        $heavy = $request->heavy;

        $product_image = $request->file('product_image');

        $stok = $request->stok;

        if (!$product_image) {
            DB::table('products')
                ->where('product_id', $product_id)
                ->where('type', 'supplier')
                ->update([
                    'product_name' => $product_name,
                    'product_description' => $product_description,
                    'price' => $price,
                ]);

            DB::table('stocks')
                ->where('product_id', $product_id)
                ->update([
                    'stok' => $stok,
                ]);
        }

        if ($product_image) {
            $jumlah_product_image = count($product_image);
            $products_lama = DB::table('product_images')
                ->where('product_id', $product_id)
                ->get();
            $asal_gambar = 'asset/u_file/product_image/';
            foreach ($products_lama as $products_lama) {
                $product_image_lama = public_path(
                    $asal_gambar . $products_lama->product_image_name
                );
                if (File::exists($product_image_lama)) {
                    File::delete($product_image_lama);
                }
            }

            DB::table('product_images')
                ->where('product_id', $product_id)
                ->delete();

            DB::table('products')
                ->where('type', 'supplier')
                ->where('product_id', $product_id)
                ->update([
                    'product_name' => $product_name,
                    'product_description' => $product_description,
                    'price' => $price,
                    'heavy' => $heavy,
                ]);

            for ($x = 0; $x < $jumlah_product_image; $x++) {
                $nama_product_image[$x] =
                    time() . '_' . $product_image[$x]->getClientOriginalName();
                $tujuan_upload = './asset/u_file/product_image';
                $product_image[$x]->move(
                    $tujuan_upload,
                    $nama_product_image[$x]
                );

                DB::table('product_images')->insert([
                    'product_id' => $product_id,
                    'product_image_name' => $nama_product_image[$x],
                ]);
            }

            DB::table('stocks')
                ->where('product_id', $product_id)
                ->update([
                    'stok' => $stok,
                ]);
        }

        return redirect('../produksupplier');
    }

    public function PostEditJasaKreatif(Request $request, $service_id) {
        $service_name = $request -> service_name;
        $service_description = $request -> service_description;
        $price = $request -> price;

        $service_image = $request -> file('service_image');

        if(!$service_image){
            DB::table('services')->where('service_id', $service_id)->update([
                'service_name' => $service_name,
                'service_description' => $service_description,
                'price' => $price,
            ]);
        }

        if($service_image){
            $jumlah_service_image = count($service_image);
            $services_lama = DB::table('service_images')->where('service_id', $service_id)->get();
            $asal_gambar = 'asset/u_file/service_image/';
            foreach($services_lama as $service_lama){
                $service_image_lama = public_path($asal_gambar . $service_lama->service_image_name);
                if(File::exists($service_image_lama)){
                    File::delete($service_image_lama);
                }
            }

            DB::table('service_images')->where('service_id', $service_id)->delete();

            DB::table('services')->where('service_id', $service_id)->update([
                'service_name' => $service_name,
                'service_description' => $service_description,
                'price' => $price,
            ]);

            for($x=0; $x<$jumlah_service_image; $x++){
                $nama_service_image[$x] = time().'_'.$service_image[$x]->getClientOriginalName();
                $tujuan_upload = './asset/u_file/service_image';
                $service_image[$x]->move($tujuan_upload,$nama_service_image[$x]);

                DB::table('service_images')->insert([
                    'service_id' => $service_id,
                    'service_image_name' => $nama_service_image[$x],
                ]);
            }
        }

        return redirect('../jasa_kreatif');
    }

    /**
     * Menghapus produk dengan menyimpan perubahan untuk " table " pada tabel " products ".
     */

    public function HapusProdukSupplier($product_id)
    {
        if (Auth::check()) {
            if (Session::get('toko')) {
                $toko = Session::get('toko');

                DB::table('products')->where('product_id', $product_id)->where('type', 'supplier')->update([
                    'is_deleted' => 1,
                ]);

                return redirect('../produk');
            }
        }
    }

    public function HapusJasaKreatif($service_id) {
        DB::table('services')->where('service_id', $service_id)->update([
            'is_deleted' => 1,
        ]);

        return redirect('../jasa_kreatif');
    }

    // public function PostEditProduk(Request $request, $product_id) {
    //     $product_name = $request -> product_name;
    //     $product_description = $request -> product_description;
    //     $price = $request -> price;
    //     $product_image = $request -> file('product_image');
    //     $stok = $request -> stok;

    //     if(!$product_image){
    //         DB::table('products')->where('product_id', $product_id)->update([
    //             'product_name' => $product_name,
    //             'product_description' => $product_description,
    //             'price' => $price,
    //         ]);

    //         DB::table('stocks')->where('product_id', $product_id)->update([
    //             'stok' => $stok,
    //         ]);
    //     }

    //     if($product_image){
    //         $products_lama = DB::table('products')->where('product_id', $product_id)->first();
    //         $asal_gambar = 'asset/u_file/product_image/';
    //         $product_image_lama = public_path($asal_gambar . $products_lama->product_image);

    //         if(File::exists($product_image_lama)){
    //             File::delete($product_image_lama);
    //         }

    //         $nama_product_image = time().'_'.$product_image->getClientOriginalName();
    //         $tujuan_upload = './asset/u_file/product_image';
    //         $product_image->move($tujuan_upload,$nama_product_image);

    //         DB::table('products')->where('product_id', $product_id)->update([
    //             'product_name' => $product_name,
    //             'product_description' => $product_description,
    //             'price' => $price,
    //             'product_image' => $nama_product_image,
    //         ]);

    //         DB::table('stocks')->where('product_id', $product_id)->update([
    //             'stok' => $stok,
    //         ]);
    //     }

    //     return redirect('../produk');
    // }

    public function lihat_produk_supplier($product_id)
    {
        $product = DB::table('products')
            ->where('product_id', $product_id)
            ->where('is_deleted', 0)
            ->join(
                'categories',
                'products.category_id',
                '=',
                'categories.category_id'
            )
            ->where('categories.type', 'supplier')
            ->join(
                'merchants',
                'products.merchant_id',
                '=',
                'merchants.merchant_id'
            )
            ->orderBy('product_id', 'desc')
            ->first();

        $product_images = DB::table('product_images')
            ->where('product_id', $product_id)
            ->orderBy('product_image_id', 'asc')
            ->get();

        // $product_category_id = DB::table('products')->select('category_id')->where('product_id', $product_id)->first();

        $product_specifications = DB::table('product_specifications')
            ->join(
                'products',
                'product_specifications.product_id',
                '=',
                'products.product_id'
            )
            ->join(
                'specifications',
                'product_specifications.specification_id',
                '=',
                'specifications.specification_id'
            )
            ->join(
                'specification_types',
                'specifications.specification_type_id',
                '=',
                'specification_types.specification_type_id'
            )
            ->where('product_specifications.product_id', $product_id)
            ->get();

        // $category_type_specifications = DB::table('category_type_specifications')
        // ->join('categories', 'category_type_specifications.category_id', '=', 'categories.category_id')
        // ->join('specification_types', 'category_type_specifications.specification_type_id', '=', 'specification_types.specification_type_id')
        // ->where('category_type_specifications.category_id', $product_category_id->category_id)->orderBy('category_type_specification_id', 'asc')->get();

        // $specification_types = DB::table('specification_types')->orderBy('nama_jenis_spesifikasi', 'asc')->get();

        $stocks = DB::table('stocks')
            ->where('product_id', $product_id)
            ->first();

        $cek_merchant_address = DB::table('merchant_address')
            ->where('merchant_id', $product->merchant_id)
            ->exists();

        $reviews = DB::table('reviews')
            ->where('product_id', $product_id)
            ->join('profiles', 'reviews.user_id', '=', 'profiles.user_id')
            ->orderBy('review_id', 'desc')
            ->get();

        $jumlah_review = DB::table('reviews')
            ->where('product_id', $product_id)
            ->count();

        $lokasi_toko = ["province" => "", "city" => "", "subdistrict_name" => ""];

        $total_terjual = DB::table("product_purchases")->where("product_id", $product->product_id)->count();

        if ($cek_merchant_address) {
            $merchant_address = DB::table('merchant_address')
                ->where('merchant_id', $product->merchant_id)
                ->first();
            $lokasi_toko = ["province" => $merchant_address->province_name, "city" => $merchant_address->city_name, "subdistrict_name" => $merchant_address->subdistrict_name];
        }
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $cek_alamat = DB::table('user_address')
                ->where('user_id', $user_id)
                ->first();
            $cek_review = DB::table('reviews')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->first();
            $cek_wishlist = DB::table('wishlists')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->first();
            return view(
                'user.lihat_produk_supplier',
                compact([
                    'product',
                    'product_images',
                    'product_specifications',
                    'stocks',
                    'cek_merchant_address',
                    'merchant_address',
                    'reviews',
                    'jumlah_review',
                    'cek_alamat',
                    'cek_review',
                    'lokasi_toko',
                    'cek_wishlist',
                    'total_terjual',
                ])
            );
        } else {
            $cek_wishlist = null;
            return view(
                'user.lihat_produk_supplier',
                compact([
                    'product',
                    'product_images',
                    'product_specifications',
                    'stocks',
                    'cek_merchant_address',
                    'merchant_address',
                    'reviews',
                    'jumlah_review',
                    'lokasi_toko',
                    'cek_wishlist',
                    'total_terjual',
                ])
            );
        }
    }

    public function produksupplier_toko()
    {
        $products = DB::table('products')->where('is_deleted', 0)->join('categories', 'products.category_id', '=', 'categories.category_id')->where('categories.type', 'supplier')
            ->join('merchants', 'products.merchant_id', '=', 'merchants.merchant_id')->orderBy('product_name', 'asc')->get();

        $product_specifications = DB::table('product_specifications')
            ->join('products', 'product_specifications.product_id', '=', 'products.product_id')
            ->join('specifications', 'product_specifications.specification_id', '=', 'specifications.specification_id')
            ->join('specification_types', 'specifications.specification_type_id', '=', 'specification_types.specification_type_id')->get();

        $stocks = DB::table('stocks')->get();

        return view('admin.produksupplier_toko')->with('products', $products)->with('product_specifications', $product_specifications)->with('stocks', $stocks);
    }
}

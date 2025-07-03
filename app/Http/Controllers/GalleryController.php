<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseRequest;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $request->input('query') ?? '';
        $total = Gallery::where('is_accepted', '=', '1')->where('user_id', auth()->user()->id)->count();
        $categories_galleries = Gallery::where('is_accepted', '=', '1')->select(DB::raw('count(*) as total'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('category_id')->get();

        $galleries_sold = Gallery::where('merchant_id', auth()->user()->merchant->merchant_id)
            ->with(['transaction' => function ($query) {
                $query->select('gallery_id', 'quantity');
            }])
            ->paginate(10);

        foreach ($galleries_sold as $gallery) {
            foreach ($gallery->transaction as $checkout) {
                $gallery->sold_out += $checkout->quantity;
            }
        }

        // return $categories_galleries;
        return view('user.toko.gallery.index', compact('total', 'categories_galleries', 'galleries_sold'));
    }


    public function warehouseListAPI()
    {
        $warehouse = Warehouse::where('user_id', auth()->user()->id)->paginate(1)->withQueryString();

        return response()->json($warehouse);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('user.toko.gallery.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WarehouseRequest $request)
    {
        $input = $request->validated();
        // return $input;
        // $image = $request->file('upload-image');

        // $imageName = time() . '.' . $image->getClientOriginalExtension();

        // $image->move(public_path('images'), $imageName);

        Gallery::create(
            [
                'merchant_id' => auth()->user()->merchant->merchant_id,
                'user_id' => auth()->user()->id,
                'category_id' => $input["jenis_produk"],
                'product_name' => $input['nama_produk'],
                'expired_at' => $input['expired_date'],
                'product_description' => $input['deskripsi_produk'],
                'price' => $input['harga'],
                'heavy' => $input['berat'],
                'stok' => $input['jumlah'],
                'image' => $input['upload_image'],
                'is_request' => 1,
                'is_accepted' => 0,
                'alasan_ditolak' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Mollitia eligendi deleniti cum tempore. Ipsa laudantium architecto perspiciatis cupiditate, rerum omnis temporibus non. Ducimus beatae deleniti, hic esse dignissimos recusandae maxime!',
                'in_gallery' => 0,
                'is_deleted' => 0,
            ]
        );

        return redirect()->route('gallery.index')->with('status', 'Success menambah request');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

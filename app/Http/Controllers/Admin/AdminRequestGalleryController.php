<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\GalleryCheckout;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminRequestGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery = Gallery::where('is_accepted', '!=', 1)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.galeri.request_gallery', compact('gallery'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->data;
        $totalPrice = 0;

        $id = collect($data)->map(function ($item) {
            return [
                $item['id'] => [
                    'quantity' => $item['quantity'],
                ],
            ];
        })->toArray();

        

        $arrayId = array_reduce($id, function($carry, $item) {
            $key = key($item);
            $carry[$key] = $item[$key];
            return $carry;
        }, []);
    

        foreach ($data as $item) {
            $id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $totalPrice += $quantity * $price;

            $data = Gallery::where('id', $id)->first();

            $data->stok = $data->stok - $quantity;

            Gallery::where('id', $id)->update(['stok' => $data->stok]);
        }

        $transaction = Transaction::create([
            'total' => $totalPrice,
        ]);

        $transaction->gallery()->attach($arrayId);

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::find($id);
        $categories = Category::all();
        return view('admin.galeri.detail_request_gallery', compact('gallery', 'categories'));
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
        $gallery = Gallery::find($id);
        if ($request->has('simpan_produk')) {
            // Jika tombol "Simpan Produk" diklikg
            $gallery->is_accepted = 1; // Set status "is_accepted" menjadi 1

            $gallery->save();

            return redirect()->route('admin.request.gallery.index')->with('success', 'item has been accepted!');
        } elseif ($request->has('tolak_produk')) {
            $gallery->is_accepted = 2;
            $gallery->alasan_ditolak = $request->alasan_ditolak;

            $gallery->save();
            return redirect()->route('admin.request.gallery.index')->with('success', 'item has been rejected!');
        }
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

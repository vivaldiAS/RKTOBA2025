<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery = Gallery::where('is_accepted', 1)->where('stok', '>', 0)->paginate(10);
        return view('admin.galeri.index', compact('gallery'));
    }

    public function history()
    {
        $transactions = Transaction::with('gallery.category')->get();
        return view('admin.galeri.history', compact('transactions'));
    }

    public function historyDetail($id)
    {
        $transactions = Transaction::where('id', $id)->with('gallery.category', 'gallery.merchant')->first();
        return view('admin.galeri.history_detail', compact('transactions'));
    }

    public function soldout()
    {
        $galleries = Gallery::where('merchant_id', 31)
            ->with(['transaction' => function ($query) {
                $query->select('gallery_id', 'quantity');
            }])
            ->get();

        foreach ($galleries as $gallery) {
            foreach ($gallery->transaction as $checkout) {
                $gallery->sold_out += $checkout->quantity;
            }
        }

        return $galleries;
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
        //
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

    public function checkout()
    {
        $gallery = Gallery::where('is_accepted', 1)->get();
        return view('admin.galeri.checkout', compact('gallery'));
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

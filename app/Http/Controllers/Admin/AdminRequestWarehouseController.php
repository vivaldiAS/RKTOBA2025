<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class AdminRequestWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::where('is_accepted', '!=', 1)->orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.warehouse.request_warehouse', compact('warehouses'));
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
        $warehouses = Warehouse::find($id);
        $categories = Category::all();
        return view('admin.warehouse.detail_request_warehouse', compact('warehouses', 'categories'));
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
        $warehouse = Warehouse::find($id);
        if ($request->has('simpan_produk')) {
            // Jika tombol "Simpan Produk" diklik
            $warehouse->is_accepted = 1; // Set status "is_accepted" menjadi 1
            $warehouse->save();
            return redirect()->route('admin.request.warehouse.index')->with('success', 'item has been accepted!');
        } elseif ($request->has('tolak_produk')) {
            $warehouse->alasan_ditolak = $request->alasan_ditolak;
            // dd($id);
            // Jika tombol "Tolak Permintaan" diklik
            $warehouse->is_accepted = 2;
            $warehouse->save();
            return redirect()->route('admin.request.warehouse.index')->with('success', 'item has been rejected!');
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

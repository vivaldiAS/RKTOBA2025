<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategory = SubCategory::all();
        $category = Category::all();

        return view('admin.sub_kategori_produk', compact('subCategory', 'category'));
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
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sub_kategori' => 'required',
            'category_id' => 'required'
        ]);

        SubCategory::create($request->all());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoryRequest  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'nama_sub_kategori' => 'required',
        //     'category_id' => 'required'
        // ]);

        // $subCategory->update($request->all());

        // return redirect()->back();

        $data = [
            'nama_sub_kategori' => $request -> nama_sub_kategori,
            'category_id' => $request -> category_id,
        ];
    
        // Update the data in the database
        DB::table('sub_categories')->where('id', $id)->update($data);
    
        // Redirect to the page that shows the updated data
        // return redirect()->route('users.show', $id)->with('success', 'User updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
    }
}

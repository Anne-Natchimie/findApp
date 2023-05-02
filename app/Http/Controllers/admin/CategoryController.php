<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::orderBy('name', 'asc')->paginate(10) ; 
        return view('admin.category.index', compact('categories')) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $categoryModel = new Category ; 

        $request->validate(['nomCategory'=>'required|min:3']) ; 
        
        $categoryModel->name = $request->nomCategory ;
        $categoryModel->icone = 'icone' ;
        $categoryModel->save(); 

        return redirect(route('admin.category.add')) ; 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        //
        $category = Category::findOrFail($id) ; 

        $request->validate(['nomCategory'=>'required|min:3']) ; 
        
        $category->name = $request->nomCategory ;
        $category->icone = 'icone' ;
        $category->update(); 

        return redirect(route('admin.category')) ; 

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $category = Category::findOrFail($id) ; 
        $category->delete(); 

        return redirect(route('admin.category')) ; 

    }
}

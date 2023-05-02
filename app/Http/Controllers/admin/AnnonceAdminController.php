<?php

namespace App\Http\Controllers\admin;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class AnnonceAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $annonces = Annonce::orderBy('name', 'asc')->paginate(10) ; 
        return view('admin.annonce.liste', compact('annonces')) ; 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::orderBy('name', 'asc')->paginate(10) ; 
        return view('admin.annonce.add', compact('categories')) ; 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //dd($request) ; 

        $annonceModel = new Annonce ; 

        $request->validate(['nomAnnonce'=>'required|min:3',
                            'category'=>'required',
                            'price'=>'required']) ; 

        $annonceModel->category_id = $request->category ;
        $annonceModel->user_id = Auth::user()->id; 
        $annonceModel->name = $request->nomAnnonce ;
        $annonceModel->description = $request->description ; 
        $annonceModel->price = $request->price ; 

        if ($request->file()) {

            $fileName = $request->image->store('public/images') ;
            $annonceModel->image = $fileName ; 
            }

        $annonceModel->save(); 

        return Redirect::route('admin.annonce.store') ; 

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
    public function edit(string $id)
    {
        //
        $annonce = Annonce::findOrFail($id) ;
        $categories = Category::orderBy('name', 'asc')->get() ;
        return view('admin.annonce.add', compact('annonce', 'categories')) ; 

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $annonce = new Annonce ; 

        $request->validate(['nomAnnonce'=>'required|min:3',
                            'category'=>'required',
                            'price'=>'required']) ; 

        $annonce->category_id = $request->category ;
        $annonce->user_id = Auth::user()->id; 
        $annonce->name = $request->nomAnnonce ;
        $annonce->description = $request->description ; 
        $annonce->price = $request->price ; 

        if ($request->file()) {

            if ($annonce->image != '') {
                Storage::delete($annonce->image) ; 
            }

            $fileName = $request->image->store('public/images') ;
            $annonce->image = $fileName ; 
            }

        $annonce->save(); 

        return Redirect::route('admin.annonce') ; 


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $annonce = Annonce::findOrFail($id) ; 
        $annonce->delete(); 

        return redirect(route('admin.annonce')) ; 
    }
}

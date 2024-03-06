<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        // dd($request);
        $categorie =  $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        if ($categorie) {
            Categorie::create([
                'name' => $categorie['name'],
                'user_id' => 1,
            ]);

            return redirect()->route('profile')->with('status', 'Categorie créé avec succès');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $categorie = Categorie::find($request->id);


        if (!$categorie) {

            return redirect()->route('profile')->with('status', 'Categorie not found');
        }

        $categorie->delete();

        return redirect()->route('profile')->with('status', 'Categorie est suppremer');
    }
}

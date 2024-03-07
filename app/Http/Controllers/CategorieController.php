<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check()) {
            $user = Auth::user();
            $categorie =  $request->validate([
                'name' => 'required|string|max:255|unique:categories',
            ]);

            if ($user->roleId->name != 'admin') {

                return redirect()->route('home');
            }

            if ($categorie) {
                Categorie::create([
                    'name' => $categorie['name'],
                    'user_id' => 1,
                ]);

                return redirect()->route('admin')->with('status', 'Categorie créé avec succès');
            }
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->roleId->name != 'admin') {
                return redirect()->route('home')->with('status', 'Unauthorized');
            }

            $categorie = Categorie::find($request->id);

            if (!$categorie) {
                return redirect()->route('home')->with('status', 'Category not found');
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $categorie->update($validatedData);

            return redirect()->route('admin')->with('status', 'Category updated successfully');
        } else {
            return redirect()->route('home')->with('status', 'Unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->roleId->name != 'admin') {
                return redirect()->route('home')->with('status', 'Unauthorized');
            }

            $categorie = Categorie::find($request->id);

            if (!$categorie) {
                return redirect()->route('home')->with('status', 'Category not found');
            }

            $categorie->delete();

            return redirect()->route('admin')->with('status', 'Category deleted successfully');
        } else {
            return redirect()->route('home')->with('status', 'Unauthorized');
        }
    }
}

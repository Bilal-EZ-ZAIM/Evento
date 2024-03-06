<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Evenment;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvenmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $evenement = Evenment::with('user')->with('ville')->get();
        $evenement = Evenment::with('user')->with('ville')->with('catecory')->latest()->paginate(6);

        // dd($evenement);
        // return response()->json($evenement);

        return view('home', compact('evenement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function recherch(Request $request)
    {
        $query = $request->get('query');


        // Filtrer les événements par titre
        $evenement = Evenment::with('user')
            ->with('ville')
            ->with('catecory')
            ->where('titre', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(6);


        return view('home', compact('evenement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $evenement = $request->validate([
            'titre' => 'required|string|min:3|max:30',
            'description' => 'required|string|max:255',
            'date' => 'required|date|min:8',
            'nombre_places' => 'required|integer|min:1',
        ]);

        Evenment::create([
            'titre' => $evenement["titre"],
            'description' => $evenement["description"],
            'date' => $evenement["date"],
            'ville_id' => $request->ville,
            'nombre_places' => $evenement["nombre_places"],
            'categorie_id' => $request->categorie_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('profile')->with('status', 'Événement créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $evenement = Evenment::where('id', $request->id)->first();

        return view('detalise', compact("evenement"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $evenement = Evenment::where('id', $request->id)->first();

        // dd($evenement);
        return view('edite', compact("evenement"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $evenement = Evenment::find($request->id);


        if (!$evenement) {
            return response()->json(['evenement' => 'Evenment not found'], 404);
        }

        $evenement->update($request->all());

        return redirect()->route('profile');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $evenement = Evenment::find($request->id);


        if (!$evenement) {

            return redirect()->route('profile')->with('status', 'Evenment not found');
            
        }

        $evenement->delete();

        return redirect()->route('profile')->with('status', 'Evenment est suppremer');
    }
}

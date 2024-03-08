<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
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
        $evenement = Evenment::where('accepter', 1)->latest()->paginate(6);
        $user = Auth::user();
        $category = Categorie::all();

        if ($user) {
            $reservation = Reservation::where('user_id', $user->id)->get();
            return view('home', compact('evenement', 'reservation', 'category'));
        }

        return view('home', compact('evenement' , 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function recherch(Request $request)
    {
        $query = $request->get('query');
        $category = Categorie::all();


        // Filtrer les événements par titre
        $evenement = Evenment::with('user')
            ->with('ville')
            ->with('catecory')
            ->where('titre', 'like', '%' . $query . '%')
            ->where('accepter', 1)
            ->latest()
            ->paginate(6);

        return view('home', compact('evenement', 'category'));
    }

    public function recherchCategory(Request $request)
    {
        $query = $request->get('query');
        $category = Categorie::all();


        // Filtrer les événements par titre
        $evenement = Evenment::with('user')
            ->with('ville')
            ->with('catecory')
            ->where('categorie_id', $query)
            ->where('accepter', 1)
            ->latest()
            ->paginate(6);

        return view('home', compact('evenement', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->roleId->name == 'utilisateur') {
            return redirect()->route('home')->with('status', 'Unauthorized action');
        }

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
            'prix' => $request->prix,
            'auto' => $request->auto,
            'accepter' => 0,
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




        if ($evenement->accepeter != 0) {

            return back()->with('status', 'Désolé, les réservations pour cet événement ne sont pas encore ouvertes');
        }

        return view('detalise', compact("evenement"));
    }

    public function show1(Request $request)
    {
        $user = Auth::user();



        $request->validate([
            'id' => 'required|exists:evenments,id',
        ]);

        $evenement = Evenment::findOrFail($request->id);


        if ($evenement->accepeter == 0) {

            return back()->with('status', 'Désolé, les réservations pour cet événement ne sont pas encore ouvertes');
        }

        if ($user->id != $evenement->user_id) {

            if ($evenement->accepeter == 0) {
                return back()->with('status', 'Désolé, les réservations pour cet événement ne sont pas encore ouvertes');
            }

            return view('detalise', compact('evenement'));
        }



        return view('detalise', compact("evenement"));
    }


    public function accepter(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $evenement = Evenment::where('id', $request->id)->first();

            if (!$evenement) {
                return redirect()->route('home')->with('status', 'Event not found or unauthorized action');
            }

            if ($user->roleId->name != 'admin') {
                return redirect()->route('home')->with('status', 'Unauthorized action');
            }

            $evenement->accepter = true;
            $evenement->save();

            return back()->with('status', 'Event accepted successfully');
        }

        return redirect()->route('login');
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $evenement = Evenment::where('id', $request->id)->first();
        return view('edite', compact("evenement"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $evenement = Evenment::find($request->id);

            if (!$evenement) {
                return redirect()->route('profile')->with('status', 'Event not found');
            }

            if ($evenement->user_id !== $user->id) {

                return redirect()->route('profile')->with('status', 'Unauthorized');
            }

            $validatedData = $request->validate([
                'titre' => 'required|string',
                'description' => 'required|string'
            ]);

            $evenement->update($validatedData);

            return redirect()->route('profile')->with('status', 'Event updated successfully');
        } else {
            return redirect()->route('profile')->with('status', 'Unauthorized');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $evenement = Evenment::find($request->id);

            if (!$evenement) {
                return redirect()->route('profile')->with('status', 'Event not found');
            }

            if ($evenement->user_id !== $user->id) {
                return redirect()->route('profile')->with('status', 'Unauthorized');
            }

            $evenement->delete();

            return redirect()->route('profile')->with('status', 'Event deleted successfully');
        } else {
            return redirect()->route('profile')->with('status', 'Unauthorized');
        }
    }
}

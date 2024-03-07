<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Models\Evenment;
use App\Models\Ticek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
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
    public function ajouter1(Request $request)
    {

        if (Auth::check()) {
            $user = Auth::user();

            $evenement = Evenment::find($request->id);

            dd($evenement);

            if ($user && $evenement) {
                if ($evenement->accepter == 1) {
                    if ($evenement->nombre_places > 0) {
                        $reservation = Reservation::create([
                            'user_id' => $user->id,
                            'etat_id' => 1,
                            'evenement_id' => $evenement->id,
                        ]);

                        if ($reservation) {
                            return back()->with('status', 'Réservation ajoutée avec succès');
                        }
                    } else {
                        return back()->with('status', 'Désolé, il n\'y a plus de places disponibles pour cet événement');
                    }
                }
            }
            return back()->with('status', 'Une erreur est survenue lors de la réservation');
        } else {
            return redirect()->route('login')->with('status', 'Vous devez vous connecter pour effectuer une réservation');
        }
    }

    public function ajouter(Request $request)
    {
        $user = Auth::user();



        $request->validate([
            'id' => 'required|exists:evenments,id',
        ]);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez vous connecter pour effectuer une réservation');
        }

        $evenement = Evenment::findOrFail($request->id);

        if ($evenement->accepeter == 1) {
            return back()->with('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement');
        }

        if ($evenement->nombre_places <= 0) {
            return back()->with('error', 'Désolé, il n\'y a plus de places disponibles pour cet événement');
        }


        if ($evenement->auto == 0) {

            Reservation::create([
                'user_id' => $user->id,
                'etat_id' => 1,
                'evenemont_id' => $evenement->id,
            ]);

            return back()->with('statu', 'Réservation ajoutée avec succès');
        }

        if ($evenement->auto == 1) {


            $reservation = Reservation::create([
                'user_id' => $user->id,
                'etat_id' => 2,
                'evenemont_id' => $evenement->id,
            ]);


            if ($reservation) {
                Ticek::create([
                    'reservation' => $reservation->id,
                ]);

                return back()->with('statu', 'Ticek ajoutée avec succès');
            }
        }







        // Mettre à jour le nombre de places disponibles
        $evenement->decrement('nombre_places');

        return back()->with('status', 'Réservation ajoutée avec succès');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = Auth::user();

        $evenement = Evenment::where('id', $request->id)->first();

        if ($user->id == $evenement->user_id) {
            $reservation = Reservation::where('evenemont_id', $request->id)->with('user')->with('etat')->where('etat_id', 1)->get();


            return view('detalise', compact("evenement", "reservation"));
        }


        return view('detalise', compact("evenement"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function accepeter(Request $request)
    {

        $user = Auth::user();
        $reservation = Reservation::find($request->id);

        $evenement = Evenment::find($reservation->evenemont_id);



        if ($user->id == $evenement->user_id) {;

            if (!$reservation) {
                return back()->with('status', 'Reservation not found');
            }

            $valideReservation = $reservation->update(['etat_id' => 2]);

            if ($valideReservation) {

                $evenement->update(['nombre_places' => $evenement->nombre_places - 1]);
                Ticek::create([
                    'reservation' => $reservation->id,
                ]);

                return back()->with('status', 'Reservation accepted');
            } else {
                return back()->with('status', 'Failed to update reservation');
            }
        } else {
            return back()->with('status', 'Unauthorized action');
        }
    }


    public function anniller(Request $request)
    {
        $user = Auth::user();

        $evenement = Evenment::find($request->id);

        if ($evenement && $user->id == $evenement->user_id) {
            $reservation = Reservation::find($request->reservation_id);

            if (!$reservation) {
                return back()->with('status', 'Reservation not found');
            }

            $reservation->update(['etat_id' => 3]);

            return back()->with('status', 'Annuler la réservation');
        } else {
            return back()->with('status', 'Unauthorized action');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Models\Evenment;
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
    public function ajouter(Request $request)
    {
        $user = Auth::user();


        $evenement = Evenment::where('id', $request->id)->first();



        if ($user && $evenement) {
            if ($evenement->nombre_places > 0) {
                $reservation = Reservation::create([
                    'user_id' => $user->id,
                    'etat_id' => 1,
                    'evenemont_id' => $evenement->id,
                ]);

                if ($reservation) {
                    return back()->with('status', 'Oui mouseire');
                }
            } else {
                return back()->with('status', 'Nous sommes désollé pour le conteter de tickes  est la fini');
            }
        }
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
            $reservation = Reservation::where('evenemont_id', $request->id)->with('user')->with('etat')->get();

            return view('detalise', compact("evenement", "reservation"));
        }



        return view('detalise', compact("evenement"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function accepeter(Request $request)
    {

        $numberDeReservation = Reservation::where('evenemont_id',$request->id)->where('etat_id' , 2)->count();
      
        

        $user = Auth::user();

        $evenement = Evenment::where('id', $request->id)->first();

        

        if ($user->id == $evenement->user_id) {

            
            $reservation = Reservation::find($request->id);


            if (!$reservation) {
                return back()->with('status' , 'reservation not found');
            }

            $valideReservation =  $reservation->update(
                [
                    'etat_id' => 2
                ]
            );

            if($valideReservation){
                $evenement->update([
                    'nombre_places' => $evenement->nombre_places - 1,
                ]);
            }

            return back()->with('status' , 'Accepter le resirvation');

        }
    }

    public function anniller(Request $request)
    {
        $user = Auth::user();

        $evenement = Evenment::where('id', $request->id)->first();

        if ($user->id == $evenement->user_id) {

            
            $reservation = Reservation::find($request->id);


            if (!$reservation) {
                return back()->with('status' , 'reservation not found');
            }

            $reservation->update(
                [
                    'etat_id' => 3
                ]
            );

            return back()->with('status' , 'Anniller le resirvation');

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}

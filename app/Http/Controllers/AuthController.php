<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Evenment;
use App\Models\User;
use App\Models\Ville;
use App\Notifications\ForgetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $evenement = Evenment::latest()->where('user_id' , $user->id)->get();
        $ville = Ville::all();
        $catecory = Categorie::all();
        // dd($evenement);

        return view('profile', compact('user', 'evenement' , 'ville' , 'catecory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/Ahouthification/regester');
    }

    public function getLogin()
    {
        return view('/Ahouthification/login');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function regester(Request $request)
    {
        

        $user =  $request->validate([
            'username' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        //Pa$$w0rd!



        if ($user) {

            User::create([
                'username' => $user["username"],
                'email' => $user["email"],
                'password' => bcrypt($user["password"]),
                'typeUser' => 'user',
            ]);

            return view('/Ahouthification/login');
        }
    }

    public function upload(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $profile = User::find($user->id);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $imageName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $currentDate = date('Y_m_d');
                $newImageName = $imageName . '_' . $currentDate . '.' . $extension;

                $image->move(public_path('uploads'),  $newImageName);
                $imageUrl = url('/uploads/' . $newImageName);

                $profile->image_path = $imageUrl;
                $profile->save();

                return redirect()->route('profile')->with(['success' => "L'image a été téléchargée avec succès."]);
            } else {
                return redirect()->back()->with(['error' => "Une erreur est survenue lors du téléchargement de l'image."]);
            }
        }

        return redirect()->back()->with(['error' => "Aucune image n'a été téléchargée."]);
    }




    public function login(Request $request)
    {

        $user =  $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        $credentials = $request->only('email', 'password');



        $user = User::where('email', $request->email)->first();

        if ($user && password_verify($credentials['password'], $user->password)) {

            Auth::login($user);

            $authenticatedUser = Auth::user();
            return       redirect()->route('home');;
        } else {
            return response()->json(['error' => 'Email or password is incorrect'], 401);
        }
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
    public function destroy(string $id)
    {
        //
    }

    public function logOut()
    {
        
        Auth::logout();

        return redirect()->route('login');
    }

}

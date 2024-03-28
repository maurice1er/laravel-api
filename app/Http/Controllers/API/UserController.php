<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest; // Ne pas oublier
use App\Http\Resources\UserResource; // Ne pas oublier
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $users = User::paginate(10);

        // On retourne les informations des utilisteurs en JSON
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        // La validation de données
        // $this->validate($request, [
        //     'name' => 'required|max:100',
        //     'email' => 'required|email|unique:users',
        //     'password' => 'require|min:8'
        // ]);

        // On crée un nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \bcrypt($request->password)
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // On retourne les informations de l'utilisateur en JSON
        return UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {
         // La validation de données
        //  $this->validate($request, [
        //     'name' => 'required|max:100',
        //     'email' => 'required|email',
        //     'password' => 'require|min:8'
        // ]);

         // On modifie les informations de utilisateur
         $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \bcrypt(request->password)
        ]);

        // On retourne la reponse JSON
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // On supprime l'utilisateur
        $user->destroy();

        // On retourne la réponse JSON
        return response()->json();
    }


    /**
     * Create token for user
    */
    public function createToken(Request $request) {
        // validation des données
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
     
        // Recherche de l'utilisateur dans la base de donnée
        $user = User::where('email', $request->email)->first();
     
        // Vérifier si le mot de passe de l'utilisateur correspond
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;
        
        // On retourne le token en JSON
        return response()->json([
            "success" => true,
            'token' => $token
        ]);
    }
}

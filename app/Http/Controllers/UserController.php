<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Liste de tous les utilisateurs
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Création d'un utilisateur (Inscription)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['user' => $user, 'token' => $user->createToken('auth_token')->plainTextToken], 201);
    }

    // Connexion et génération du Token
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    // Profil de l'utilisateur connecté
    public function profile(Request $request)
    {
        // On récupère l'utilisateur connecté
        $user = $request->user();

        // On charge la relation 'fanzines' définie dans le modèle User
        // On inclut les données de la table pivot (status, purchased_at)
        $user->load(['fanzines' => function($query) {
            $query->withPivot('status', 'purchased_at');
        }]);

        return response()->json($user, 200);
    }

    // Déconnexion (Supprime le token)
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté avec succès'], 200);
    }
}
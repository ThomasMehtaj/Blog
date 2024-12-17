<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 401,
                'message' => 'Identifiants incorrects'
            ], 401);
        }
        // Créer un cookie HTTPOnly pour stocker le token JWT
        $cookie = cookie('token', $token, 60 * 24, null, null, false, true); // Cookie expirant dans 24 heures
        return response()->json([
            'message' => 'Connexion réussie',
            'user' => auth()->user(),
        ])->withCookie($cookie);
    }

    public function logout()
    {
    // Supprimer le token JWT en déconnectant l'utilisateur
    JWTAuth::invalidate(JWTAuth::getToken());

    // Créer un cookie expiré pour supprimer le cookie du navigateur
    $cookie = cookie('token', '', -1, null, null, false, true); // Expire immédiatement

    return response()->json(['message' => 'Déconnexion réussie'])
        ->withCookie($cookie); // Ajouter le cookie expiré à la réponse
    }

    // Route de test pour vérifier si l'utilisateur est authentifié
    public function me()
    {
        return response()->json(auth()->user());
    }
}
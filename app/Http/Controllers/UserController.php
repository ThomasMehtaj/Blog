<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'user' => $user,
                'message' => 'Connexion réussie'
            ]);
        }

        return response()->json([
            'message' => 'Identifiants incorrects'
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Vous avez été déconnecté']);
    }

    // Route de test pour vérifier si l'utilisateur est authentifié
    public function user()
    {
        return response()->json(Auth::user());
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Ejecutar la consulta de manera segura con parámetros enlazados
        $passwordQuery = DB::select(
            DB::raw("SELECT PASSWORD(:password) AS password_result"),
            ['password' => $request->password]
        );

        // Extraer el resultado de la consulta
        $password = $passwordQuery[0]->password_result ?? null;
        $request->merge(['password' => $password]);
        
        $userCredentials = $request->only('username', 'password');

        if (Auth::attempt($userCredentials)) {
            $user = $request->user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}

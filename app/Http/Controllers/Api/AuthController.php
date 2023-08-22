<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // $password = \DB::select(\DB::raw("SELECT PASSWORD($request->password) AS password_result"))[0]->password_result;
        // $request->merge(['password' => $password]);
        
        $userCredentials = $request->only('username', 'password');

        if (Auth::attempt($userCredentials)) {
            $user = $request->user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

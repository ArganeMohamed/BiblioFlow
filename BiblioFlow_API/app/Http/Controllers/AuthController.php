<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function Register (Request $r) {
        
        $r->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string'
        ]);

        $user = User::create([
            'nom' => $r->nom,
            'prenom' => $r->prenom,
            'email' => $r->email,
            'password' => Hash::make($r->password),
            'role' => $r->role
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(["status" => 200 , "user" => $user, "token" => $token ]);

    }

    public function login(Request $request) {
        
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['status' => 401 ,'message' => 'Invalid credentials']);
            }
        } catch (JWTException $e) {
            return response()->json(['status' => 500, 'message' => 'Could not create token']);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 200,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function checkToken(Request $request) {
        try {
            $token = JWTAuth::parseToken()->authenticate();
            return response()->json(['status' => 200, 'message' => 'Token is valid']);
        } catch (\Exception $e) {
            return response()->json(['status' => 401 , 'error' => 'Unauthorized']);
        }

    }

}

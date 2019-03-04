<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\EventNewRegister;

class AuthenticatorController extends Controller
{
    public function register(Request $request) {
        
        $request->validate([
            'name'      => 'required|string',
            'email'     => 'required|string|email|unique:users',
            'password'  => 'required|string|confirmed'
        ]);

        $user = new User([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'token'     => str_random(60)
        ]);

        $user->save();

        event(new eventNewRegister($user));

        return response()->json([
            'res'=>'User created successfully'
        ], 201);
    }

    public function login(Request $request) {
        
        $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string'
        ]);

        $credentials = [
            'email'     => $request->email,
            'password'  => $request->password,
            'active'    => 1
        ];

        if( !Auth::attempt($credentials) ) {
            return response()->json([
                'res' => 'Access denied'
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Access token')->accessToken;

        return response()->json([
            'token' => $token
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return response()->json([
            'res' => 'Successfully logged out'
        ]);
    }

    public function registeractivate($id, $token) {
        $user = User::find($id);

        if( $user ){
            if ($user->token == $token) {
                $user->active = true;
                $user->token = '';
                $user->save();
                return view('activeregister');
            }
        }
        return view('errorregister');
    }
}

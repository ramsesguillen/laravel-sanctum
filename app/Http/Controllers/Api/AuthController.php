<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register( Request $request )
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => ['required', 'confirmed']
        ]);


        $user = User::create([
            'name' => $request->password,
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

        event( new Registered( $user ) );

        $token = $user->createToken('authtoken');

        return response()->json([
            'message' => 'user Resitered',
            'data' => [ 'token' => $token->plainTextToken, 'user' => $user ]
        ]);
    }


    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function login( Request $request )
    {

        $request->validate([
            'email' => 'required',
            "password" => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if ( !Auth::attempt( $credentials )) {
            return response(['ok' => false], 401);
        }

        // return $request->user();

        $token = $request->user()->createToken('authtoken');

        return response()->json([
            'message' => 'Logged',
            'data' => [
                'user'=> $request->user(),
                'token'=> $token->plainTextToken
            ]
        ]);
    }


    public function logout( Request $request )
    {
        // $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out'
        ]);
    }
}

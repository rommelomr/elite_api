<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $req){

    	$req->validate([
    		'username' => ['required'],
    		'password' => ['required']
    	]);

    	if(Auth::attempt($req->only('username','password'))){
    		
    		$user = Auth::user();

    		$token = $user->createToken('Personal Access Token')->accessToken;
    		
    		return response()
    			->json([
    				'user' => $user,
    				'token' => $token,
    			],200);

    	}else{
    		return response()->json([
                'login_code' => 0,
    			'messages' => [
    				'Datos de ingreso inválidos'
    			]

    		]);
    	}
    	

    }

    public function logout(Request $request){

        Auth::user()->token()->revoke();
        return response()->json([
            'messages' => [
                'Cierre de sesión exitoso'
            ]
        ]);
    }
    public function register(Request $req){

    	

    }
    
}

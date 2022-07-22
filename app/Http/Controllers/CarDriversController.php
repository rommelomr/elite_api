<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CarDriver;
use Illuminate\Support\Facades\Hash;

class CarDriversController extends Controller
{
    public function registerDriver(Request $req){
        
    	$user = User::create([
			'username' 	=> $req->username,
			'email' 	=> $req->email,
			'password' 	=> Hash::make($req->password),
    	]);

    	

    	CarDriver::create([
    		'user_id' => $user->id,
    	]);

    	return response()->json([
    		'messages'=>[
    			'Conductor registrado'
    		]
    	]);

    }
}

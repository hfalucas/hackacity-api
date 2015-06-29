<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
	function __construct() {
		$this->middleware('cors');
	}
    
    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');

        if (! $token = \JWTAuth::attempt($credentials)) {
			return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return response()->json(['token' => $token, 'user' => 
        	[
        		'id' => \JWTAuth::toUser($token)->id,
        		'name' => \JWTAuth::toUser($token)->name,
        		'email' => \JWTAuth::toUser($token)->email,
        	] 
        ]);
    }


}

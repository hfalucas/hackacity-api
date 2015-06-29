<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{

	function __construct() {
        $this->middleware('jwt.auth');
		$this->middleware('cors');
	}
   
    public function store(Request $request)
    {
    	$user = \JWTAuth::parseToken()->toUser();
        $input = $request->only('local_id', 'description', 'duration');
        $input = array_add($input, 'user_id', $user->id);

        $event = \App\Event::create( $input );
        $event->users()->attach($user->id);

        if( ! $event ) return response()->json(['message' => 'Ups! n00b'], 500);

        return response()->json(['message' => 'Created'], 200);

    }

    public function show($localId)
    {
     	$event = \App\Event::with('users')
     				->where('local_id', $localId)
     				->first();  
     	if ( ! $event ) return response()->json(['message' => 'Damn! You just missed it.'], 404);

     	return $event;
    }

    public function join($eventId)
    {
    	$user = \JWTAuth::parseToken()->toUser();
    	$event = \App\Event::find($eventId);

    	$event->users()->attach($user->id);

    	response()->json(['message' => 'User Joined Event'], 200);
    }

}

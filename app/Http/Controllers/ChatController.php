<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Events\ChatEvent;
use session;

class ChatController extends Controller
{
 	 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  	
   	//
	public function chat()
	{
		return view('chat');
	}	

	public function send(Request $request)
	{
		$user = User::find(Auth::id());
		$this->saveToSession($request);

		event(new ChatEvent($request->message,$user));
	}

	public function saveToSession(Request $request)
	{
		session()->put('chat', $request->chat);
	}

	public function getOldMessage()
	{
		return session('chat');
	}

	public function deleteSession()
	{
		session()->forget('chat');
	}

//	public function send()
//	{
//		$message = "hello People";
//		$user = User::find(Auth::id());
//
//		event(new ChatEvent($message,$user));
//	}
}

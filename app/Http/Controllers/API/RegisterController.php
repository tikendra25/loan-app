<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mail;
use App\Mail\WelcomeEmail;

class RegisterController extends Controller
{
    public function __invoke(RegisterUserRequest $request){
		$payload = $request->only('name','email','password');
		$payload['password'] =Hash::make($payload['password']);
		$user = User::create($payload);
		
		Mail::to($user)->send( new WelcomeEmail($user));	
		
		return $user;	
	}
}

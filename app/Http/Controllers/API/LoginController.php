<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request){
		
		$payload =['email' =>$request->email, 'password' =>$request->password];
		if(Auth::attempt($payload )){
			$request->bearerToken();
			return ['status'=>'success','token'=>$request->user()->createToken('loan_app')->plainTextToken,'messge'=>'Loing sucessfull, use this token'];
		}else{
			return ['status'=>'fail','token'=>'','messge'=>'Invalid Login Details'];
		}
	}
}

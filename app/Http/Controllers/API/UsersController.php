<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserLoansResource;

class UsersController extends Controller
{	
	public function __invoke(Request $request){	
		$loans =\Auth::user()->loan()->get();
		return UserLoansResource::collection($loans);
	}
}

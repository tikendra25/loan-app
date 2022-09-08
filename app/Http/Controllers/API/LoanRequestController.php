<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoanRequestController extends Controller
{
    public function __invoke(Request $request){
		$payload = $request->only('amount','tenure');
		$payload['user_id'] = $request->user()->id;
		$loan = Loan::create($payload);	
		return $loan;	
	}
}

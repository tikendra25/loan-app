<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emi;
use App\Models\Payment;

class PaymentControler extends Controller
{
    public function __invoke(Request $request){
		$emi_id = $request->emi_id;
		if($emi_id){
			$emi =Emi::with('loan')->where('id',$emi_id)->first()->toArray();
			if(isset($emi['status']) && $emi['status']=='0'){
				/*integrate any payment gateway*/
				
				$payment = ['loan_id'=>$emi['loan']['id'],'emi_id'=>$emi_id, 'amount'=>$emi['emi_amount'], 'status'=>'1'];
				$res 	 = Payment::create($payment);
				if($res){
					$eres =Emi::where('id',$emi_id)->update(['status'=>'1']);
				}
				return ['status'=>'success','message'=>'Emi Payemnt Done'];					
			}else{			
				return ['status'=>'success','message'=>'Emi Payemnt Allready Done'];	
			}
		}else{
			return ['status'=>'failed','message'=>'Emi Object not found'];	
		}
	}
}

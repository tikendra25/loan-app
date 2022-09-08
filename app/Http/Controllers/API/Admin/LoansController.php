<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Emi;
use Mail;
use App\Mail\UpdateLoanEmail;
use Carbon\Carbon;
use PDF;

class LoansController extends Controller
{
    public function loans(){
		return Loan::with('user')->get()->toArray();
	} 
	
	public function loanapproveandreject(Request $request){
		$payload 	= $request->only('status','comment');
		$loanstatus = Loan::where('id',$request->loan_id)->pluck('status')->first();		
		$result  	= Loan::where('id',$request->loan_id)->update($payload);		
		if($result){
			$loan =Loan::with('user')->where('id',$request->loan_id)->first()->toArray();			
			$data			= []; $attachment='';
			$data['name']	= $loan['user']['name'];
			$data['email']	= $loan['user']['email'];
			$data['status']	= ($loan['status']=='1')?'Approved':'Rejected';
			if($payload['status']=='1') {
                $tenure = $loan['tenure'];
                $amount = $loan['amount'];
                $interest		= $loan['rate_of_interest'];
                $emi 			= $amount / $tenure;
				$interestAmount = ($emi / $interest);  
				$emiAmount		= $emi+$interestAmount;
				$emiDetails 	= [];
                for($i=1; $i <=$tenure; $i++) {
                    $emiDetails[] = [
                        'loan_id' => $loan['id'],
                        'emi_number' => $i,
                        'emi_amount' => number_format($emiAmount,2,'.',''),
                        'interest_amount' => number_format($interestAmount,2, '.',''),
                        'status' =>'0',
                        'created_at' =>date('Y-m-d H:i:s'),
                    ];   
                }				
				if(count($emiDetails)){
					if($loanstatus!=$payload['status']){
						Emi::insert($emiDetails);	
					}
				}
				
				$outstanding =Emi::where('loan_id',$request->loan_id)->where('status','0')->sum('emi_amount');

				$data['emis'] = [
					'start_date' => Carbon::parse($loan['updated_at'])->format('d M Y'),
					'finish_date' => Carbon::parse($loan['updated_at'])->addMonths($loan['tenure'])->format('d M Y'),
					'total_emis' => $tenure,
					'loan_amount' => number_format($amount,2, '.',''),
					'pending_emis' => Emi::where('loan_id',$request->loan_id)->where('status','0')->count(),
					'outstanding_amount' => number_format($outstanding,2, '.',''),
					'monthly_emi_amount' => number_format($emiAmount,2, '.','')
				];		
				/** Loan PDF Code **/
				$attachment = "LoanApproval_".$request->loan_id."_".date('Ymdhis').".pdf";
				$pdf 		= PDF::loadView('pdf.loanapproval', $data);
				$path 		= public_path('pdf/');
				$pdf->save($path . '/' . $attachment);
				$pdf->stream($attachment);

				$data['comment'] = "Loan Approved Sucessfully";
            } else {
                $data['comment'] = $loan['comment'];
            }
			
			Mail::to($loan['user']['email'],$loan['user']['name'])->queue(new UpdateLoanEmail($data,$attachment));
			//Mail::to($loan['user']['email'],$loan['user']['name'])->send(new UpdateLoanEmail($data,$attachment));
			return ['status'=>'success','message'=>$data['comment']];
		}
		return ['status'=>'failed','message'=>'Loan not processed, we are facing technical issue..'];	
	}
}

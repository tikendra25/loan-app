<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;

class Emi extends Model
{
    use HasFactory;
	
	/**
	* The attributes that are mass assignable.
	*
	* @var array<int, string>
	*/
	protected $fillable = [
        'loan_id',
        'emi_number',
        'emi_amount',
        'interest_amount',
        'status',
    ];
	
	public function loan(){
		return $this->hasOne(Loan::class,'id','loan_id');
	}
}

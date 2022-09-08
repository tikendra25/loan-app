<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Emi;
use App\Models\Payment;

class Loan extends Model
{
    use HasFactory;
	
	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'tenure',
		'rate_of_interest',
        'user_id',
        'type',
        'status',
        'comment',
    ];
	
	public function user(){
		return $this->hasOne(User::class,'id','user_id');
	}
	
	public function emi(){
		return $this->hasMany(Emi::class,'loan_id','id');
	}
	
	public function payment(){
		return $this->hasMany(Payment::class,'loan_id','id');
	}
	
}

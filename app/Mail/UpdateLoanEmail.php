<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateLoanEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;


	public $data;
	public $attachment;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
	 
    public function __construct($data,$attachment)
    {
        $this->data=$data;
        $this->attachment=$attachment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('email.updateloanemail',$this->data);
		if($this->attachment!=''){
			$filepath = public_path('pdf/'). '/' . $this->attachment;
			$email->attach($filepath);
		}
		
		return $email;
    }
}

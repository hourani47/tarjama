<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Merchant extends Mailable
{
    use Queueable, SerializesModels;


    public $email;
    public $ingredients = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email , $ingredients)
    {
        //
        $this->email = $email;
        $this->ingredients = $ingredients;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Stock Category need To Upgrade')
            ->with(['ingredients'=> $this->ingredients])
            ->markdown('emails.merchants');
    }
}

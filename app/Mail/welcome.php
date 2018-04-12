<?php

namespace skyimport\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use skyimport\Models\Country;

class welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $var;

    public function __construct($var = null)
    {
        $this->var = $var;
    }

    public function build()
    {
        return $this->view('emails.welcome');
    }
}

<?php

namespace skyimport\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use skyimport\Models\Country;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.welcome', ['data' => $this->data]);
    }
}

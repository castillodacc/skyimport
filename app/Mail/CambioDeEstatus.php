<?php

namespace skyimport\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CambioDeEstatus extends Mailable
{
    use Queueable, SerializesModels;

    public $consolidado;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($consolidado)
    {
        $this->consolidado = $consolidado;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $consolidado = $this->consolidado;
        return $this->view('emails.cambioDeEstatus', compact('consolidado'));
    }
}

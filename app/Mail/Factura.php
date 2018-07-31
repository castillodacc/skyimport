<?php
namespace skyimport\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use skyimport\Models\consolidated;
class Factura extends Mailable
{
    use Queueable, SerializesModels;
    public $id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $consolidated = consolidated::findOrFail($this->id);
        return $this->view('emails.bills', compact('consolidated'))
        ->subject('Orden de servicio ' . $consolidated->number);
    }
}
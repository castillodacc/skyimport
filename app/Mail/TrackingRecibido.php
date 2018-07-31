<?php
namespace skyimport\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use skyimport\Models\Tracking;
class TrackingRecibido extends Mailable
{
    use Queueable, SerializesModels;
    
    public $tracking;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tracking)
    {
        $this->tracking = $tracking;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = Tracking::findOrFail($this->tracking);
        if ($data->eventsUsers->last()->events->id == 12) {
            $subject = 'Tracking recibido en U.S.A.';
        } else {
            $subject = $data->eventsUsers->last()->events->event;
        }
        return $this->view('emails.trackingrecibido', compact('data'))
        ->subject($subject);
    }
}
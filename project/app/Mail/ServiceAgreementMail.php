<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceAgreementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order_id;
    public $link;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id, $link)
    {
        $this->order_id = $order_id;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("shredEX Order#".$this->order_id.":  Your Shredding Service Agreement")
            ->view('emails.service_agreement_link')
            ->with('link',  $this->link);
    }
}

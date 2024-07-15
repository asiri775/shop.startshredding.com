<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ServiceAgreementPDFMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $documents;
    public $order_details;
    public $path;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $documents, $order_details, $path)
    {
        $this->order = $order;
        $this->documents = $documents;
        $this->order_details = $order_details;
        $this->path = $path;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("shredEX Order#".$this->order->id.":  Your Shredding Service Agreement")
            ->view('vendor.service_agreement_email')
            ->with('documents',  $this->documents)
            ->with('order',  $this->order)
            ->with('order_details',  $this->order_details)
            ->attach($this->path);
    }
}

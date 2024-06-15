<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use \Illuminate\Mail\Mailables\Attachment;


class PurchaseReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $tickets;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct($purchase, $tickets, $pdf)
    {
        $this->purchase = $purchase;
        $this->tickets = $tickets;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.purchase_receipt')
                    ->subject('Your Purchase Receipt')
                    ->attachData($this->pdf, 'receipt.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }

    
}

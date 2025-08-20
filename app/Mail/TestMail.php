<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function build()
    {
        // keep From as your Gmail; use replyTo if you want replies elsewhere
        return $this->subject($this->details['subject'] ?? 'Order Confirmation')
                    ->view('emails.test')
                    ->with([
                    'order_id' => $this->details['order_id'],
                    'customer_name'  => $this->details['customer_name'] ?? '',
                    'customer_phone' => $this->details['customer_phone'] ?? '',
                    'customer_email' => $this->details['gmail'] ?? '',
                    'customer_address' => $this->details['address'] ?? '',
                    'total'          => $this->details['total'] ?? 0,
                ])
                    ->replyTo($this->details['reply_to'] ?? config('mail.from.address'));
    }
}


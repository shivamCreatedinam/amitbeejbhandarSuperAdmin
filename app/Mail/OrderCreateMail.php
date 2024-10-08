<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;
    public $from_mail;
    public function __construct($order, $from_mail)
    {
        $this->order = $order;
        $this->from_mail = $from_mail;
    }

    public function build()
    {
        $email = $this->view('emails.new-order')
            ->with([
                'id' => $this->order->id,
                'name' => $this->order->name,
                'email' => $this->order->email,
                'mobile' => $this->order->mobile,
                'order_date' => \Carbon\Carbon::parse($this->order->created_at)->format('d M Y h:i A'),
                'company_name' => $this->from_mail->website_name,
                'company_email' => $this->from_mail->from_mail_address,
                'items' => json_decode($this->order->quotes, true),
            ]);

        Log::channel("lead")->info("Lead : " . $this->order->quotes);

        // Set the "From" address and name
        return $email->from($this->from_mail->from_mail_address, $this->from_mail->from_mail_name)->subject($this->from_mail->website_name . " - New Order Received.");;
    }
}

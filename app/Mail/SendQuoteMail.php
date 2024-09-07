<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendQuoteMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $messageContent;
    public $attachmentPath;
    public $recipient_data;
    public $from_mail;
    public function __construct($messageContent, $from_mail, $recipient_data, $attachmentPath = null)
    {
        $this->messageContent = $messageContent;
        $this->from_mail = $from_mail;
        $this->recipient_data = $recipient_data;
        $this->attachmentPath = $attachmentPath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('emails.quote')
            ->with([
                'name' => $this->recipient_data->name,
                'company_name' => $this->from_mail->website_name,
                'company_email' => $this->from_mail->from_mail_address,
                'messageContent' => $this->messageContent
            ]);

        if (!is_null($this->attachmentPath) && !empty($this->attachmentPath)) {
            $email->attach("storage/app/public/" . $this->attachmentPath);
        }

        // Set the "From" address and name
        return $email->from($this->from_mail->from_mail_address, $this->from_mail->from_mail_name)->subject($this->from_mail->website_name . " - Inquiry Mail");;
    }
}

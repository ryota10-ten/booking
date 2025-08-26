<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnnouncementMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $bodyText;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectText, $bodyText)
    {
        $this->subjectText = $subjectText;
        $this->bodyText = $bodyText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectText)
                    ->view('emails.announcement')
                    ->with([
                        'bodyText' => $this->bodyText,
                    ]);
    }
}

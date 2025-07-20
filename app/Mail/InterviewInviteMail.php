<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $link;
    public $isAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $link, $isAdmin = false)
    {
        $this->user = $user;
        $this->link = $link;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Interview Invitation')
            ->view('emails.interview')
            ->with([
                'name' => $this->user->name,
                'link' => $this->link,
                'isAdmin' => $this->isAdmin,
            ]);
    }
}

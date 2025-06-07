<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShowBookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $show;
    public $order;
    public $isPractitioner;
    public $response;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $show,$order,$isPractitioner, $response = null)
    {
        $this->user = $user;
        $this->show = $show;
        $this->order = $order;
        $this->isPractitioner = $isPractitioner;
        $this->response = $response;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject("{$this->user->first_name} {$this->user->last_name}, Your Show Booking is Confirmed 🌸")
            ->view('emails.show_booking_confirmation')
            ->with([
                'user' => $this->user,
                'show' => $this->show,
                'isPractitioner' => $this->isPractitioner,
                'order' => $this->order,
                'response' => $this->response ?? false,
            ]);
    }


}

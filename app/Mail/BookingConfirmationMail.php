<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $practitionerEmailTemplate;
    public $intakeForms;
    public $order;
    public $isPractitioner;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $practitionerEmailTemplate, $intakeForms ,$isPractitioner = false)
    {
        $this->user = $user;
        $this->practitionerEmailTemplate = $practitionerEmailTemplate;
        $this->intakeForms = $intakeForms;
        $this->isPractitioner = $isPractitioner;
    }


    /**
     * Build the message.
     */
    public function build()
    {
        ;
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject("{$this->user->first_name} {$this->user->last_name}, Your Booking on The Hira Collective is Confirmed 🌸")
            ->view('emails.booking_confirmation')
            ->with([
                'user' => $this->user,
                'practitionerEmailTemplate' => $this->practitionerEmailTemplate,
                'intakeForms' => $this->intakeForms,
//                'order' => $this->order,
                'isPractitioner' => $this->isPractitioner ?? false,
            ]);
    }
}

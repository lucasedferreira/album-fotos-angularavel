<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailConfirmationRegister extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url('/api/auth/register/activate/' . $this->user->id . '/' . $this->user->token);
        return $this->view('emails.confirmationregister')->with([
            'name' => $this->user->name,
            'email' => $this->user->email,
            'link' => $link,
            'datehour' => now()->setTimezone('America/Sao_Paulo')->format('d-m-Y H:i:s')
        ]);
    }
}

<?php

namespace App\Listeners;

use App\Events\EventNewRegister;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Mail\EmailConfirmationRegister;
use Illuminate\Support\Facades\Mail;

class ListenerEmailConfirmation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventNewRegister  $event
     * @return void
     */
    public function handle(EventNewRegister $event)
    {
        Mail::to($event->user)
            ->send(new EmailConfirmationRegister($event->user));
    }
}

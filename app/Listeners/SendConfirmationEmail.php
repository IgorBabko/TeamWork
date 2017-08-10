<?php

namespace App\Listeners;

use Mail;
use App\Events\UserCreated;
use App\Mail\UserConfirmation;

class SendConfirmationEmail
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        Mail::to($event->user)->send(new UserConfirmation()); 
    }
}

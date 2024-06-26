<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;


class SendVerificationEmail
{

     use InteractsWithQueue;
    

    public function handle(UserRegistered $event): void
    {
        Mail::to($event->user->email)->send(new VerificationEmail());
    }
}

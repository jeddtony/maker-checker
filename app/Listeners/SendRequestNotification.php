<?php

namespace App\Listeners;

use App\Events\RequestMade;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendRequestNotification
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
     * @param  \App\Events\RequestMade  $event
     * @return void
     */
    public function handle(RequestMade $event)
    {
        //
        $users = User::where('uuid', '!=', $event->pendingRequest->admin_uuid)
        ->where('is_admin', 1)->get();
        foreach ($users as $user) {
            Mail::send('emails.request-made', ['pendingRequest' => $event->pendingRequest], function ($message) use ($user) {
                        $message->to($user->email)
                        ->from('events@maker-checker.com')->subject('Request Made');
        });
        }
    }
}

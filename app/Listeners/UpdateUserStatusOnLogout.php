<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;

class UpdateUserStatusOnLogout
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
     * @param  object  $event
     * @return void
     */

     public function handle(Logout $event)
     {
         $user = $event->user;
         $user->status = 'offline'; // تعيين الحالة إلى غير متصل
         $user->save();
     }
}

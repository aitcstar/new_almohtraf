<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;


class UpdateUserStatusOnLogin
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

     public function handle(Login $event)
     {
         $user = $event->user;
         $user->status = 'online'; // تعيين الحالة إلى متصل
         $user->save();
     }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Message;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    public function boot()
    {
        try{
            View::composer('*', function ($view) {
                if (auth()->check()) {
                    $lasrnotifications = Notification::where('user_id', auth()->id())
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'desc')
                    ->paginate(4);

                    $view->with('lasrnotifications', $lasrnotifications);
                }
            });

            View::composer('*', function ($view) {
                if (auth()->check()) {
                    $userId = auth()->id();
                    $messages = Message::getLastThreeMessages($userId);
                    $view->with('latestMessages', $messages);
                }
            });

        } catch (\Exception $e) {
        }
    }
}

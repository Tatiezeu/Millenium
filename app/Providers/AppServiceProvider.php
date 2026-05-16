<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('layouts.dashboard', function ($view) {
            if (auth()->check()) {
                $unreadCount = \App\Models\Notification::where('receiver_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
                
                $navbarNotifications = \App\Models\Notification::with('sender')
                    ->where('receiver_id', auth()->id())
                    ->latest()
                    ->take(5)
                    ->get();

                $view->with([
                    'unreadNotificationsCount' => $unreadCount,
                    'navbarNotifications' => $navbarNotifications
                ]);
            }
        });
    }
}

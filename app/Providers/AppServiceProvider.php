<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

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
    public function boot()
    {
        View::composer(['admin.messages-admin', 'admin.dashboard-admin', 'admin.users-admin', 'admin.calendar','admin.settings'], function ($view) {
            $notifications = Notification::with('user')->orderByDesc('dateSent')->get();

            $userNotifications = Notification::where('user_id', auth()->id())
                ->where('status', 'unread')
                ->orderByDesc('dateSent')
                ->get();

            $unreadCount = $userNotifications->count();

            $view->with([
                'notifications' => $notifications,
                'userNotifications' => $userNotifications,
                'unreadCount' => $unreadCount
            ]);
        });
    }
}

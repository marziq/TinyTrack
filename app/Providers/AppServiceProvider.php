<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer(['admin.messages-admin', 'admin.dashboard-admin', 'admin.users-admin', 'admin.calendar','admin.settings', 'user.mybaby', 'dashboard', 'user.growth', 'user.settings', 'user.appointment', 'user.milestone', 'user.myaccount', 'user.tips', 'user.chatbot', 'user.checkup'], function ($view) {
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

        View::composer(
            ['dashboard', 'user.mybaby'],
            function ($view) {
                $user = Auth::user();

                // Check if user has babies
                $baby = $user->babies->first(); // Get the first baby or null if no babies

                // Pass data to the view
                $view->with('baby', $baby);
        });

        View::composer('admin.calendar', function ($view) {
                $users = User::all();
                $view->with('users', $users);
         });

        // Share the preference with all views
        View::composer('*', function ($view) {
        // Get preference (e.g., from Auth user, or fall back to cookie/session)
        $isDarkMode = auth()->check()
            ? auth()->user()->dark_mode
            : request()->cookie('dark_mode', false); // Example fall back

        $view->with('isDarkMode', $isDarkMode);
         });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Booking;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share pending bookings count to sidebar
        View::composer('partials.sidebar', function ($view) {
            $pendingBookingsCount = Booking::where('status', 'pending')->count();
            $view->with('pendingBookingsCount', $pendingBookingsCount);
        });
    }
}

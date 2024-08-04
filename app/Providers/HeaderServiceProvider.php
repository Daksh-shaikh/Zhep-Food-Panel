<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Restro; // Update the namespace to match the actual location of your Restro model

class HeaderServiceProvider extends ServiceProvider
{

    public function boot()
    {
        view()->composer('admin.layout.header', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Assuming 'restaurant' is the name of the field in the User table
                $restaurantName = $user->restaurant;

                // Retrieve the Restro record based on the restaurant name
                $restro = Restro::where('restaurant', $restaurantName)->first();

                $view->with('restro', $restro);
            } else {
                $view->with('restro', null);
            }
        });
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    // public function boot()
    // {
    //     //
    // }
}

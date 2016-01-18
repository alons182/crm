<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('dashboard/index', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('clients/partials._form', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('tasks/partials._form', function($view) {
            $view->with('currentUser', Auth::user());
        });
        view()->composer('layouts/partials._navbar', function($view) {
            $view->with('currentUser', Auth::user());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

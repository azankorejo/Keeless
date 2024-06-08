<?php

namespace App\Providers;

use App\Models\Team;
use App\Observers\TeamObserver;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Team::observe(TeamObserver::class);
        $this->app->bind('Laravel\Fortify\Http\Requests\LoginRequest', \App\Http\Requests\LoginRequest::class);

        Inertia::share([
            'errors' => function () {
                return Session::get('errors')
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object)[];
            }
            ]);
    }
}

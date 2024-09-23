<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Binding a logger instance
        $this->app->singleton('App\Logging\CustomLogger', function ($app) {
            return new \App\Logging\CustomLogger();
        });

        // Binding an event manager
        $this->app->singleton('App\Events\EventManager', function ($app) {
            return new \App\Events\EventManager();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register any application services
        Event::listen('task.create', function ($data) {
            // Handle the event
            Log::info('Event triggered: ', $data);
        });
    }
}

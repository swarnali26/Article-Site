<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'cors' => \App\Http\Middleware\Cors::class,
        'Authmiddleware'=> \App\Http\Middleware\Authmiddleware::class,
    ];
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
    protected $middleware = [
        \App\Http\Middleware\Cors::class
    ];
}

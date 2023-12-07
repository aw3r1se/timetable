<?php

namespace Aw3r1se\Timetable;

use Closure;
use Illuminate\Support\ServiceProvider;

class TimetableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $config_path = __DIR__ . '/../config/timetable.php';
        $migrations_path = __DIR__ . '/../database/migrations/';

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $config_path => config_path('timetable.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . $migrations_path . 'stubs/' => database_path('migrations'),
            ], 'migrations');
        }

        $this->mergeConfigFrom($config_path, 'timetable');
        $this->loadMigrationsFrom($migrations_path);
    }
}

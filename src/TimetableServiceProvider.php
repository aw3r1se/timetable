<?php

namespace Aw3r1se\Timetable;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use SplFileInfo;

class TimetableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $config_path = __DIR__ . '/../config/timetable.php';
        $migrations_path = __DIR__ . '/../database/migrations/stubs';

        /** @var array<\Symfony\Component\Finder\SplFileInfo $migrations */
        $migrations = File::files($migrations_path);
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $config_path => config_path('timetable.php'),
            ], 'config');

            foreach ($migrations as $file) {
                $timestamp = now()->format('Y_m_d_u');
                $filename = preg_replace('#\.stub$#i', '', $file->getFileName());

                $this->publishes([
                    "$migrations_path/$filename.stub"
                    => database_path('migrations') . "/{$timestamp}_$filename.php",

                ], 'migrations');
            }
        }

        $this->mergeConfigFrom($config_path, 'timetable');
    }
}

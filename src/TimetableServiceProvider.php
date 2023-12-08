<?php

namespace Aw3r1se\Timetable;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use SplFileInfo;

class TimetableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $config_path = __DIR__ . '/../config/timetable.php';
        $migrations_path = __DIR__ . '/../database/migrations/';

        $migration = 'create_time_segments_table';
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $config_path => config_path('timetable.php'),
            ], 'config');

            $this->publishes([
                $migrations_path . "stubs/$migration.stub"
                => database_path('migrations') . '/' . now()->format('Y_m_d_u') . "_$migration.php",
            ], 'migrations');
        }

        $this->mergeConfigFrom($config_path, 'timetable');

        /** @var array<SplFileInfo> $migrations */
        $migrations = File::allFiles(database_path('migrations'));
        if (!Arr::first($migrations, fn(SplFileInfo $file) => Str::contains($file->getFilename(), $migration))) {
            $this->loadMigrationsFrom($migrations_path);
        }
    }
}

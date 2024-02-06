<?php

namespace Aw3r1se\Timetable;

use Aw3r1se\Timetable\Exceptions\ModelNotDefined;
use Aw3r1se\Timetable\Exceptions\ModelNotFound;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class TimetableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $config_path = __DIR__ . '/../config/timetable.php';
        $migrations_path = __DIR__ . '/../database/migrations/stubs';

        /** @var array<SplFileInfo> $migrations */
        $migrations = File::files($migrations_path);
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $config_path => config_path('timetable.php'),
            ], 'config');

            foreach ($migrations as $file) {
                $filename = preg_replace('#\.stub$#i', '', $file->getFileName());

                $this->publishes([
                    "$migrations_path/$filename.stub"
                    => database_path('migrations') . "/$filename.php",

                ], 'migrations');
            }
        }

        $this->mergeConfigFrom($config_path, 'timetable');
    }

    /**
     * @throws ModelNotDefined
     * @throws ModelNotFound
     */
    public function boot(): void
    {
        Helpers\Schedule::isTimeRecordModelValid();
        Helpers\Schedule::isScheduleModelValid();
        Helpers\Schedule::isScheduleDayModelValid();
    }
}

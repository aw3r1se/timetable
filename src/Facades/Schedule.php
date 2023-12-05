<?php

namespace Aw3r1se\Timetable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @Schedule
 */
class Schedule extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Aw3r1se\Timetable\Services\Schedule::class;
    }
}

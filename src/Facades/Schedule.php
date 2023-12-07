<?php

namespace Aw3r1se\Timetable\Facades;


use Aw3r1se\Timetable\Enums\Month;
use Aw3r1se\Timetable\Models\TimeSegment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Facade;
use Aw3r1se\Timetable\Services;

/**
 * @Schedule
 * @method Collection<TimeSegment> getPeriod(Carbon|string|null $from, Carbon|string|null $to, callable|null $additional)
 * @method Collection<TimeSegment> byMonth(Month|null $month)
 * @method Collection<TimeSegment> byDay(Carbon|string|null $day)
 */
class Schedule extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Services\Schedule::class;
    }
}

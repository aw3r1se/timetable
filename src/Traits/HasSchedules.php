<?php

namespace Aw3r1se\Timetable\Traits;

use Aw3r1se\Timetable\Contracts\InteractsWithSchedule;
use Aw3r1se\Timetable\Services;
use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;
use Aw3r1se\Timetable\Models\Schedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Aw3r1se\Timetable\Helpers;

/**
 * @HasSchedules
 * @mixin Model
 *
 * @property-read Collection<Schedule> $schedules
 */
trait HasSchedules
{
    /**
     * @throws RelationIsNotConfigured
     */
    protected static function bootHasSchedules(): void
    {
        Helpers\Schedule::isScheduleRelationValid(static::class);
    }

    public function schedules(): MorphMany
    {
        return $this->morphMany(
            config('timetable.schedule.model'),
            config('timetable.schedule.relation.name'),
        );
    }

//    public function schedule(): Services\Record
//    {
//        /** @var InteractsWithSchedule $this */
//
//        return app(Services\Record::class)
//            ->setSchedulable($this);
//    }
}

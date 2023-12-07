<?php

namespace Aw3r1se\Timetable\Traits;

use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;
use Aw3r1se\Timetable\Models\TimeSegment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Aw3r1se\Timetable\Helpers;

/**
 * @HasSchedule
 * @mixin Model
 *
 * @property-read Collection<TimeSegment> $schedule
 */
trait HasSchedule
{
    /**
     * @throws RelationIsNotConfigured
     */
    public function schedule(): MorphMany
    {
        Helpers\Schedule::checkRelationIsValid();

        return $this->morphMany(config('timetable.segment.model'), config('timetable.segment.relation_name'));
    }
}

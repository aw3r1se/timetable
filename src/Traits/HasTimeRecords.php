<?php

namespace Aw3r1se\Timetable\Traits;

use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Services;
use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;
use Aw3r1se\Timetable\Helpers;
use Aw3r1se\Timetable\Models\TimeRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @HasTimeRecords
 * @mixin Model
 *
 * @property-read Collection<TimeRecord> $timeRecords
 */
trait HasTimeRecords
{
    /**
     * @throws RelationIsNotConfigured
     */
    protected static function bootHasTimeRecords(): void
    {
        Helpers\Schedule::isTimeRecordRelationValid(static::class);
    }

    public function timeRecords(): MorphMany
    {
        return $this->morphMany(
            config('timetable.record.model'),
            config('timetable.record.relation.name'),
        );
    }

    public function record(): Services\Record
    {
        return app(Services\Record::class)
            ->setRecordable($this);
    }
}

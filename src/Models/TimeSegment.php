<?php

namespace Aw3r1se\Timetable\Models;

use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Aw3r1se\Timetable\Helpers;

/**
 * @TimeSegment
 * @property int $id
 * @property Carbon $date
 * @property string $time_from
 * @property string $time_to
 *
 * @property-read Carbon|null $start
 * @property-read Carbon|null $end
 * @property-read Carbon|null $duration
 *
 * @property-read Model $scheduleable
 */
class TimeSegment extends Model
{
    protected $fillable = [
        'date',
        'time_from',
        'time_to',
    ];

    protected $casts = [
        'date' => 'date',
        'time_from' => 'time',
        'time_to' => 'time',
    ];

    /**
     * @throws RelationIsNotConfigured
     */
    public function scheduleable(): MorphTo
    {
        Helpers\Schedule::checkRelationIsValid();

        return $this->morphTo(config('timetable.segment.relation_name'));
    }

    public function start(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->date) {
                return null;
            }

            return $this->date
                ->setTimeFromTimeString($this->time_from);
        });
    }

    public function end(): Attribute
    {
        return Attribute::get(function () {
            if (!$this->date) {
                return null;
            }

            return $this->date
                ->setTimeFromTimeString($this->time_to);
        });
    }

    public function duration(): Attribute
    {
        return Attribute::get(function () {
            return $this->end?->diff($this->start);
        });
    }
}

<?php

namespace Aw3r1se\Timetable\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

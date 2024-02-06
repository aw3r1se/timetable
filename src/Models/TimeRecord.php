<?php

namespace Aw3r1se\Timetable\Models;

use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Exceptions\InvalidTimeRecord;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @TimeRecord
 * @property int $id
 * @property Carbon $start
 * @property Carbon $end
 *
 * @property-read InteractsWithTimeRecords $holdable
 *
 * @property-read Carbon|null $duration
 */
class TimeRecord extends Model
{
    protected $fillable = [
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saving(function (TimeRecord $record) {
            if ($record->start > $record->end) {
                throw new InvalidTimeRecord('End must be greater than start');
            }
        });
    }

    /**
     * @return MorphTo
     */
    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    public function duration(): Attribute
    {
        return Attribute::get(function () {
            return $this->end->diff($this->start);
        });
    }
}

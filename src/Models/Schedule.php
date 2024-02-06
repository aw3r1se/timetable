<?php

namespace Aw3r1se\Timetable\Models;

use Aw3r1se\Timetable\Contracts\InteractsWithSchedule;
use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Traits\HasTimeRecords;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @Schedule
 * @property int $id
 * @property string $from
 * @property string|null $to
 * @property int $week_interval
 *
 * @property-read InteractsWithSchedule $schedulable
 * @property-read Model $owner
 */
class Schedule extends Model implements InteractsWithTimeRecords
{
    use HasFactory;
    use HasTimeRecords;

    protected $fillable = [
        'from',
        'to',
        'week_interval',
    ];

    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',
    ];

    public function schedulable(): MorphTo
    {
        return $this->morphTo();
    }

    public function owner(): MorphTo
    {
        return $this->morphTo('owner');
    }
}

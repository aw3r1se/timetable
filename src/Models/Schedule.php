<?php

namespace Aw3r1se\Timetable\Models;

use Aw3r1se\Timetable\Contracts\InteractsWithSchedule;
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
 * @property InteractsWithSchedule $schedulable
 */
class Schedule extends Model
{
    use HasFactory;

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
}

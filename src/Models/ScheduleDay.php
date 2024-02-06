<?php

namespace Aw3r1se\Timetable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @ScheduleDay
 * @property int $id
 * @property int $day
 * @property Carbon $start
 * @property Carbon $end
 *
 * @property-read Schedule $schedule
 */
class ScheduleDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}

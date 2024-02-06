<?php

namespace Aw3r1se\Timetable\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface InteractsWithSchedule
{
    public const RELATION = 'owner';

    public function schedules(): MorphMany;
}

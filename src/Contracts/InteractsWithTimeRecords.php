<?php

namespace Aw3r1se\Timetable\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface InteractsWithTimeRecords
{
    public const RELATION = 'recordable';

    public function timeRecords(): MorphMany;
}

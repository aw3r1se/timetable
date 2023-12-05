<?php

namespace Aw3r1se\Timetable\Services;

use Illuminate\Support\Carbon;

class Schedule
{
    protected ?Carbon $from;

    protected ?Carbon $to;

    public function setFrom(Carbon|string $from): static
    {
        $this->from = $from instanceof Carbon
            ? $from
            : Carbon::parse($this->from);

        return $this;
    }

    public function setTo(Carbon|string $from): static
    {
        $this->to = $from instanceof Carbon
            ? $from
            : Carbon::parse($this->to);

        return $this;
    }
}

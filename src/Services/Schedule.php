<?php

namespace Aw3r1se\Timetable\Services;

use Aw3r1se\Timetable\Enums\Month;
use Aw3r1se\Timetable\Exceptions\ModelNotFound;
use Aw3r1se\Timetable\Models\TimeSegment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Aw3r1se\Timetable\Helpers;

class Schedule
{
    protected ?Carbon $from = null;

    protected ?Carbon $to = null;

    /**
     * @var string<TimeSegment>
     */
    protected string $segment;

    /**
     * @throws ModelNotFound
     */
    public function __construct()
    {
        Helpers\Schedule::checkModelIsValid();

        $this->segment = config('timetable.segment.model');
    }


    protected function setFrom(Carbon|string $from): static
    {
        $this->from = $from instanceof Carbon
            ? $from
            : $this->stringToCarbon($from);

        return $this;
    }

    protected function setTo(Carbon|string $to): static
    {
        $this->to = $to instanceof Carbon
            ? $to
            : $this->stringToCarbon($to);

        return $this;
    }

    /**
     * @param Carbon|string|null $from
     * @param Carbon|string|null $to
     * @param callable|null $additional
     * @return Collection<TimeSegment>
     */
    public function getPeriod(
        Carbon|string|null  $from = null,
        Carbon|string|null  $to = null,
        ?callable           $additional = null
    ): Collection {
        if ($from) {
            $this->setFrom($from);
        }

        if ($to) {
            $this->setTo($to);
        }

        /** @var Builder<TimeSegment> $query */
        $query = $this->segment::query()
            ->whereBetween('start_time', [$this->from, $this->to]);

        if ($additional) {
            $additional($query);
        }

        return $query->get();
    }

    /**
     * @param Month|null $month
     * @return Collection<TimeSegment>
     */
    public function byMonth(?Month $month = null): Collection
    {
        $now = Carbon::now();

        if (empty($month)) {
            $month = Month::from($now->month);
        }

        $from = (clone $now)
            ->month($month->value)
            ->firstOfMonth()
            ->startOfDay();

        $to = (clone $now)
            ->month($month->value)
            ->lastOfMonth()
            ->endOfDay();

        return $this->getPeriod($from, $to);
    }

    public function byDay(Carbon|string|null $day = null): Collection
    {
        $now = Carbon::now();
        if (empty($day)) {
            $day = $now;
        }

        $from = (clone $day)
            ->startOfDay();

        $to = (clone $day)
            ->endOfDay();

        return $this->getPeriod($from, $to);
    }

    protected function stringToCarbon(string $date): Carbon
    {
        return Carbon::parse($date);
    }
}

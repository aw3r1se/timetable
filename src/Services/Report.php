<?php

namespace Aw3r1se\Timetable\Services;

use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Models\TimeRecord;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

class Report
{
    protected ?InteractsWithTimeRecords $recordable = null;

    protected ?Carbon $start = null;

    protected ?Carbon $end = null;

    protected Builder|MorphMany $builder;

    public function __construct()
    {
        $this->builder = TimeRecord::query();
    }

    public static function query(): static
    {
        return new static();
    }

    public function setRecordable(InteractsWithTimeRecords $recordable): static
    {
        $this->recordable = $recordable;

        $this->builder = $this->recordable
            ->timeRecords();

        return $this;
    }

    public function byDay(): static
    {
        $this->start = now()
            ->startOfDay();

        return $this;
    }

    public function byWeek(): static
    {
        $this->start = now()
            ->startOfWeek();

        return $this;
    }

    public function byMonth(): static
    {
        $this->start = now()
            ->startOfMonth();

        return $this;
    }

    public function byYear(): static
    {
        $this->start = now()
            ->startOfYear();

        return $this;
    }

    public function builder(): Builder|MorphMany
    {
        return $this->builder;
    }

    public function get(): Collection
    {
        return $this->setBetweenCondition()
            ->get();
    }

    public function paginate(int $per_page = 15): LengthAwarePaginator
    {
        return $this->setBetweenCondition()
            ->paginate($per_page);
    }

    protected function setBetweenCondition(): Builder|MorphMany
    {
        return $this->builder
            ->when($this->start, fn ($query) => $query->where('start', '>=', $this->start))
            ->when($this->end, fn ($query) => $query->where('end', '<=', $this->end));
    }
}

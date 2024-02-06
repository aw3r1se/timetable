<?php

namespace Aw3r1se\Timetable\Services;

use Aw3r1se\Timetable\Contracts\InteractsWithSchedule;
use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Models\TimeRecord;
use Illuminate\Support\Carbon;

class Schedule
{
    protected ?InteractsWithSchedule $schedulable = null;

    protected InteractsWithTimeRecords $recordable;

    public function setSchedulable(InteractsWithSchedule $schedulable): static
    {
        $this->schedulable = $schedulable;

        return $this;
    }

    public function setRecordable(InteractsWithTimeRecords $recordable): static
    {
        $this->recordable = $recordable;

        return $this;
    }

    public function hold(Carbon $start, Carbon $end): void
    {
        $time_record = new TimeRecord([
            'start' => $start,
            'end' => $end,
        ]);

        if ($this->schedulable) {
            $time_record->schedule()
                ->associate($this->schedulable)
                ->save();
        }

        $time_record->recordable()
            ->associate($this->recordable)
            ->save();
    }

    public function report(): Report
    {
        return app(Report::class)
            ->setRecordable($this->recordable);
    }
}

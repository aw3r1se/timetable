<?php

namespace Aw3r1se\Timetable\Services;

use Aw3r1se\Timetable\Contracts\InteractsWithTimeRecords;
use Aw3r1se\Timetable\Exceptions\ConfigurationException;
use Aw3r1se\Timetable\Models\TimeRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Record
{
    protected InteractsWithTimeRecords $recordable;

    public function setRecordable(InteractsWithTimeRecords|Model $recordable): static
    {
        $this->recordable = $recordable;

        return $this;
    }

    /**
     * @throws ConfigurationException
     */
    public function hold(Carbon $start, ?Carbon $end = null): void
    {
        $end = $end ?? $this->getDefaultEnd($start);

        $time_record = new TimeRecord([
            'start' => $start,
            'end' => $end,
        ]);

        /** @var Model $recordable */
        $recordable = $this->recordable;

        $time_record
            ->recordable()
            ->associate($recordable)
            ->save();
    }

    public function report(): Report
    {
        /** @var Report $report */
        $report = app(Report::class);

        return $report->setRecordable($this->recordable);
    }

    /**
     * @throws ConfigurationException
     */
    protected function getDefaultEnd(Carbon $start): Carbon
    {
        $default_interval = config('timetable.record.default_interval');
        if (
            empty($default_interval)
            || !isset($default_interval['unit'])
            || !isset($default_interval['value'])
        ) {
            throw new ConfigurationException('Default interval is not set');
        }

        return $start->add(
            $default_interval['unit'],
            $default_interval['value'],
        );
    }
}

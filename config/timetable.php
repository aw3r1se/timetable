<?php

use Aw3r1se\Timetable;

return [
    'schedule' => [
        'model' => Timetable\Models\Schedule::class,
        'table_name' => 'schedules',

        'relation' => [
            'name' => Timetable\Contracts\InteractsWithSchedule::RELATION,
            'contract' => Timetable\Contracts\InteractsWithSchedule::class,
        ],

        'soft_delete' => true,

        'day' => [
            'model' => Timetable\Models\ScheduleDay::class,
            'table_name' => 'schedule_days',
            'soft_delete' => true,
        ],
    ],
    'record' => [
        'model' => Timetable\Models\TimeRecord::class,
        'table_name' => 'time_records',

        'relation' => [
            'name' => Timetable\Contracts\InteractsWithTimeRecords::RELATION,
            'contract' => Timetable\Contracts\InteractsWithTimeRecords::class,
        ],

        'soft_delete' => true,
        'start_end_index' => true,
        'default_interval' => [
            'unit' => 'minute',
            'value' => 30,
        ],
    ],
];

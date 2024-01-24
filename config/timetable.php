<?php

return [
    'schedule' => [
        'model' => Aw3r1se\Timetable\Models\Schedule::class,
        'table_name' => 'schedules',
        'relation_name' => 'holdable',
        'soft_delete' => true,
        'day' => [
            'model' => Aw3r1se\Timetable\Models\ScheduleDay::class,
            'table_name' => 'schedule_days',
            'soft_delete' => true,
        ],
    ],
    'segment' => [
        'model' => Aw3r1se\Timetable\Models\TimeSegment::class,
        'table_name' => 'time_segments',
        'relation_name' => 'holdable',
        'soft_delete' => true,
        'datetime_unique_index' => true,
        'default_min_interval' => [
            'value' => 30,
            'unit' => 'minute',
        ],
    ],
];

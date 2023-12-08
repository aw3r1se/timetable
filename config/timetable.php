<?php

return [
    'segment' => [
        'model' => Aw3r1se\Timetable\Models\TimeSegment::class,
        'table_name' => 'time_segments',
        'relation_name' => 'scheduleable',
        'unique_index' => true,
        'default_min_interval' => [
            'value' => 1,
            'unit' => 'hour',
        ],
    ],
];

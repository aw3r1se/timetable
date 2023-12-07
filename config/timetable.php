<?php

return [
    'segment' => [
        'model' => Aw3r1se\Timetable\Models\TimeSegment::class,
        'relation_name' => 'scheduleable',
        'unique_index' => true,
        'default_min_interval' => [
            'value' => 1,
            'unit' => 'hour',
        ],
    ],
];

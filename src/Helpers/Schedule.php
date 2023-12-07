<?php

namespace Aw3r1se\Timetable\Helpers;

use Aw3r1se\Timetable\Exceptions\ModelNotFound;
use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;

class Schedule
{
    /**
     * @throws ModelNotFound
     */
    public static function checkModelIsValid(): void
    {
        $segment_model = config('timetable.segment.model');
        if (empty($segment_model)) {
            throw new ModelNotFound('Timetable model is not defined');
        }

        if (!class_exists($segment_model)) {
            throw new ModelNotFound('Timetable model is not exists');
        }
    }

    /**
     * @throws RelationIsNotConfigured
     */
    public static function checkRelationIsValid(): void
    {
        $segment_relation = config('timetable.segment.relation_name');
        if (empty($segment_relation)) {
            throw new RelationIsNotConfigured('Relation is not configured');
        }
    }
}

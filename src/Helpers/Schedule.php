<?php

namespace Aw3r1se\Timetable\Helpers;

use Aw3r1se\Timetable\Exceptions\ModelNotDefined;
use Aw3r1se\Timetable\Exceptions\ModelNotFound;
use Aw3r1se\Timetable\Exceptions\RelationIsNotConfigured;

class Schedule
{
    /**
     * @throws ModelNotFound
     * @throws ModelNotDefined
     */
    public static function isTimeRecordModelValid(): void
    {
        static::isModelValid(config('timetable.record.model'));
    }

    /**
     * @throws ModelNotFound
     * @throws ModelNotDefined
     */
    public static function isScheduleModelValid(): void
    {
        static::isModelValid(config('timetable.schedule.model'));
    }

    /**
     * @throws ModelNotFound
     * @throws ModelNotDefined
     */
    public static function isScheduleDayModelValid(): void
    {
        static::isModelValid(config('timetable.schedule.day.model'));
    }

    /**
     * @throws RelationIsNotConfigured
     */
    public static function isTimeRecordRelationValid(string $entity): void
    {
        static::isRelationValid(
            $entity,
            'timetable.record.relation',
        );
    }

    /**
     * @throws RelationIsNotConfigured
     */
    public static function isScheduleRelationValid(string $entity): void
    {
        static::isRelationValid(
            $entity,
            'timetable.schedule.relation',
        );
    }

    /**
     * @throws RelationIsNotConfigured
     */
    public function isRecordRelationValid(string $entity): void
    {
        static::isRelationValid(
            $entity,
            'timetable.record.relation',
        );
    }

    /**
     * @param string|null $name
     * @return void
     * @throws ModelNotDefined
     * @throws ModelNotFound
     */
    protected static function isModelValid(?string $name = null): void
    {
        if (empty($name)) {
            throw new ModelNotDefined();
        }

        if (!class_exists($name)) {
            throw new ModelNotFound($name);
        }
    }

    /**
     * @param class-string $entity
     * @param string $config_path
     * @return void
     * @throws RelationIsNotConfigured
     */
    protected static function isRelationValid(
        string $entity,
        string $config_path,
    ): void {
        $relation = config($config_path);
        if (empty($relation['name'] ?? null)) {
            throw new RelationIsNotConfigured();
        }

        if (!class_implements($entity, $relation['contract'])) {
            throw new RelationIsNotConfigured($entity, $relation['contract']);
        }
    }
}

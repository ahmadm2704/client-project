<?php

namespace App\Models;

class SubjectArea extends BaseModel
{
    protected static $table = 'subject_areas';

    public static function getSubjectAreaByName($name)
    {
        try {
            return static::findBy('name', $name);
        } catch (\Exception $e) {
            error_log('getSubjectAreaByName error: ' . $e->getMessage());
            return null;
        }
    }

    public static function createSubjectArea($name, $createdBy)
    {
        try {
            return static::create([
                'name' => $name,
                'created_by' => $createdBy,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            error_log('createSubjectArea error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function updateSubjectAreaName($subjectAreaId, $newName)
    {
        try {
            return static::updateRecord($subjectAreaId, [
                'name' => $newName
            ]);
        } catch (\Exception $e) {
            error_log('updateSubjectAreaName error: ' . $e->getMessage());
            throw $e;
        }
    }
}

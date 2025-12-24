<?php

namespace App\Models;

class Course extends BaseModel
{
    protected static $table = 'courses';

    public static function getCoursesBySubjectArea($subjectAreaId)
    {
        try {
            return static::findAllBy('subject_area_id', $subjectAreaId);
        } catch (\Exception $e) {
            error_log('getCoursesBySubjectArea error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getFullTimeCourses()
    {
        try {
            return Database::select(static::getTable(), ['part_time_available'], [0]);
        } catch (\Exception $e) {
            error_log('getFullTimeCourses error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getPartTimeCourses()
    {
        try {
            return Database::select(static::getTable(), ['part_time_available'], [1]);
        } catch (\Exception $e) {
            error_log('getPartTimeCourses error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getCoursesByDuration($years)
    {
        try {
            return static::findAllBy('duration_years', $years);
        } catch (\Exception $e) {
            error_log('getCoursesByDuration error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getCoursesByType($type)
    {
        try {
            return static::findAllBy('type', $type);
        } catch (\Exception $e) {
            error_log('getCoursesByType error: ' . $e->getMessage());
            return [];
        }
    }

    public static function createCourse($title, $subjectAreaId, $type, $durationYears, $description, $createdBy, $partTimeAvailable = 0)
    {
        try {
            return static::create([
                'title' => $title,
                'subject_area_id' => $subjectAreaId,
                'type' => $type,
                'duration_years' => $durationYears,
                'description' => $description,
                'created_by' => $createdBy,
                'part_time_available' => $partTimeAvailable,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            error_log('createCourse error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function updateCourseDetails($courseId, $data)
    {
        try {
            $allowedFields = ['title', 'subject_area_id', 'type', 'duration_years', 'description', 'part_time_available'];
            $updateData = [];

            foreach ($allowedFields as $field) {
                if (isset($data[$field])) {
                    $updateData[$field] = $data[$field];
                }
            }

            if (empty($updateData)) {
                throw new \Exception('No valid fields to update');
            }

            return static::updateRecord($courseId, $updateData);
        } catch (\Exception $e) {
            error_log('updateCourseDetails error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function searchCourses($subjectAreaId = null, $type = null, $minDuration = null, $maxDuration = null, $partTimeOnly = null)
    {
        try {
            $sql = "SELECT * FROM " . static::getTable() . " WHERE 1=1";
            $params = [];

            if ($subjectAreaId !== null && $subjectAreaId !== '') {
                $sql .= " AND subject_area_id = ?";
                $params[] = (int) $subjectAreaId;
            }

            if ($type !== null && $type !== '') {
                $sql .= " AND type = ?";
                $params[] = $type;
            }

            if ($minDuration !== null && $minDuration !== '') {
                $sql .= " AND duration_years >= ?";
                $params[] = (int) $minDuration;
            }

            if ($maxDuration !== null && $maxDuration !== '') {
                $sql .= " AND duration_years <= ?";
                $params[] = (int) $maxDuration;
            }

            if ($partTimeOnly === true) {
                $sql .= " AND part_time_available = 1";
            }

            $sql .= " ORDER BY title ASC";

            $statement = Database::query($sql, $params);
            return $statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            error_log('searchCourses error: ' . $e->getMessage());
            return [];
        }
    }

    public static function countBySubjectArea($subjectAreaId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM " . static::getTable() . " WHERE subject_area_id = ?";
            $statement = Database::query($sql, [(int) $subjectAreaId]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (\Exception $e) {
            error_log('countBySubjectArea error: ' . $e->getMessage());
            return 0;
        }
    }

    public static function getCoursesBySubjectAreaPaginated($subjectAreaId, $page = 1, $perPage = 10)
    {
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM " . static::getTable() . " 
                    WHERE subject_area_id = ? 
                    ORDER BY title ASC 
                    LIMIT ? OFFSET ?";
            $statement = Database::query($sql, [(int) $subjectAreaId, (int) $perPage, (int) $offset]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            error_log('getCoursesBySubjectAreaPaginated error: ' . $e->getMessage());
            return [];
        }
    }

    public static function countSearchResults($subjectAreaId = null, $type = null, $minDuration = null, $maxDuration = null, $partTimeOnly = null)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM " . static::getTable() . " WHERE 1=1";
            $params = [];

            if ($subjectAreaId !== null && $subjectAreaId !== '') {
                $sql .= " AND subject_area_id = ?";
                $params[] = (int) $subjectAreaId;
            }

            if ($type !== null && $type !== '') {
                $sql .= " AND type = ?";
                $params[] = $type;
            }

            if ($minDuration !== null && $minDuration !== '') {
                $sql .= " AND duration_years >= ?";
                $params[] = (int) $minDuration;
            }

            if ($maxDuration !== null && $maxDuration !== '') {
                $sql .= " AND duration_years <= ?";
                $params[] = (int) $maxDuration;
            }

            if ($partTimeOnly === true) {
                $sql .= " AND part_time_available = 1";
            }

            $statement = Database::query($sql, $params);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (\Exception $e) {
            error_log('countSearchResults error: ' . $e->getMessage());
            return 0;
        }
    }

    public static function searchCoursesPaginated($page = 1, $perPage = 10, $subjectAreaId = null, $type = null, $minDuration = null, $maxDuration = null, $partTimeOnly = null)
    {
        try {
            $offset = ($page - 1) * $perPage;
            $sql = "SELECT * FROM " . static::getTable() . " WHERE 1=1";
            $params = [];

            if ($subjectAreaId !== null && $subjectAreaId !== '') {
                $sql .= " AND subject_area_id = ?";
                $params[] = (int) $subjectAreaId;
            }

            if ($type !== null && $type !== '') {
                $sql .= " AND type = ?";
                $params[] = $type;
            }

            if ($minDuration !== null && $minDuration !== '') {
                $sql .= " AND duration_years >= ?";
                $params[] = (int) $minDuration;
            }

            if ($maxDuration !== null && $maxDuration !== '') {
                $sql .= " AND duration_years <= ?";
                $params[] = (int) $maxDuration;
            }

            if ($partTimeOnly === true) {
                $sql .= " AND part_time_available = 1";
            }

            $sql .= " ORDER BY title ASC LIMIT ? OFFSET ?";
            $params[] = (int) $perPage;
            $params[] = (int) $offset;

            $statement = Database::query($sql, $params);
            return $statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            error_log('searchCoursesPaginated error: ' . $e->getMessage());
            return [];
        }
    }
}


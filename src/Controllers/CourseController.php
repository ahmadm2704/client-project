<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\SubjectArea;
use App\Models\Module;
use App\Models\Database;
use App\Helpers\Auth;

class CourseController
{
    private $error = '';
    private $success = '';

    public function listCourses()
    {
        Auth::requireLogin();

        $courses = Course::getAll();
        $subjectAreas = SubjectArea::getAll();
        $allModules = Module::getAll();
        $editCourse = null;
        $editModules = [];

        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];
            $editCourse = Course::getById($editId);
            if ($editCourse) {
                $editModules = $this->getModulesForCourse($editId);
            }
        }

        include __DIR__ . '/../Views/courses.php';
    }

    public function showCourse($id)
    {
        try {
            $course = Course::getById($id);

            if (!$course) {
                include __DIR__ . '/../Views/404.php';
                return;
            }

            $subjectArea = SubjectArea::getById($course['subject_area_id']);

            $modules = $this->getModulesForCourse($id);

            include __DIR__ . '/../Views/course-detail.php';
        } catch (\Exception $e) {
            error_log('showCourse error: ' . $e->getMessage());
            include __DIR__ . '/../Views/404.php';
        }
    }

    private function getModulesForCourse($courseId)
    {
        try {
            $sql = "SELECT m.* FROM modules m 
                    INNER JOIN course_modules cm ON m.id = cm.module_id 
                    WHERE cm.course_id = ? 
                    ORDER BY m.code ASC";
            $statement = Database::query($sql, [$courseId]);
            return $statement->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            error_log('getModulesForCourse error: ' . $e->getMessage());
            return [];
        }
    }

    public function saveCourse()
    {
        Auth::requireLogin();

        $courseId = isset($_POST['id']) ? (int) $_POST['id'] : null;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $subjectAreaId = isset($_POST['subject_area_id']) ? (int) $_POST['subject_area_id'] : null;
        $type = isset($_POST['type']) ? trim($_POST['type']) : '';
        $durationYears = isset($_POST['duration_years']) ? (int) $_POST['duration_years'] : null;
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $partTimeAvailable = isset($_POST['part_time_available']) ? 1 : 0;
        $moduleIds = isset($_POST['module_ids']) ? array_filter(array_map('intval', $_POST['module_ids'])) : [];

        if (empty($title)) {
            $this->error = 'Course title is required';
        } elseif (strlen($title) < 3) {
            $this->error = 'Course title must be at least 3 characters';
        } elseif (strlen($title) > 255) {
            $this->error = 'Course title must not exceed 255 characters';
        } elseif (!$subjectAreaId) {
            $this->error = 'Subject area is required';
        } elseif (empty($type)) {
            $this->error = 'Course type is required';
        } elseif (!$durationYears || $durationYears < 1 || $durationYears > 10) {
            $this->error = 'Duration must be between 1 and 10 years';
        } elseif (empty($description)) {
            $this->error = 'Course description is required';
        }

        if (empty($this->error)) {
            $subjectArea = SubjectArea::getById($subjectAreaId);
            if (!$subjectArea) {
                $this->error = 'Selected subject area does not exist';
            }
        }

        if (empty($this->error)) {
            try {
                if ($courseId) {
                    Course::updateRecord($courseId, [
                        'title' => $title,
                        'subject_area_id' => $subjectAreaId,
                        'type' => $type,
                        'duration_years' => $durationYears,
                        'description' => $description,
                        'part_time_available' => $partTimeAvailable
                    ]);

                    $this->updateCourseModules($courseId, $moduleIds);

                    $this->success = 'Course updated successfully';
                } else {
                    $result = Course::create([
                        'title' => $title,
                        'subject_area_id' => $subjectAreaId,
                        'type' => $type,
                        'duration_years' => $durationYears,
                        'description' => $description,
                        'part_time_available' => $partTimeAvailable,
                        'created_by' => Auth::getUserId(),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $courseId = is_array($result) ? $result['id'] : $result;

                    if ($courseId && !empty($moduleIds)) {
                        $this->addCourseModules($courseId, $moduleIds);
                    }

                    $this->success = 'Course created successfully';
                }

                header('Location: /courses?message=' . urlencode($this->success));
                exit;
            } catch (\Exception $e) {
                $this->error = 'An error occurred: ' . $e->getMessage();
                error_log('saveCourse error: ' . $e->getMessage());
            }
        }

        $courses = Course::getAll();
        $subjectAreas = SubjectArea::getAll();
        $editCourse = $courseId ? Course::getById($courseId) : null;
        $editModules = $courseId ? $this->getModulesForCourse($courseId) : [];
        $allModules = Module::getAll();

        include __DIR__ . '/../Views/courses.php';
    }

    private function addCourseModules($courseId, $moduleIds)
    {
        try {
            $sql = "INSERT INTO course_modules (course_id, module_id) VALUES (?, ?)";
            foreach ($moduleIds as $moduleId) {
                Database::execute($sql, [$courseId, $moduleId]);
            }
        } catch (\Exception $e) {
            error_log('addCourseModules error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function updateCourseModules($courseId, $moduleIds)
    {
        try {
            $sql = "DELETE FROM course_modules WHERE course_id = ?";
            Database::execute($sql, [$courseId]);

            if (!empty($moduleIds)) {
                $this->addCourseModules($courseId, $moduleIds);
            }
        } catch (\Exception $e) {
            error_log('updateCourseModules error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteCourse($id)
    {
        Auth::requireLogin();

        try {
            $course = Course::getById($id);

            if (!$course) {
                $this->error = 'Course not found';
            } else {
                $sql = "DELETE FROM course_modules WHERE course_id = ?";
                Database::execute($sql, [$id]);

                Course::deleteRecord($id);

                $this->success = 'Course deleted successfully';
                header('Location: /courses?message=' . urlencode($this->success));
                exit;
            }
        } catch (\Exception $e) {
            error_log('deleteCourse error: ' . $e->getMessage());
            $this->error = 'Error deleting course: ' . $e->getMessage();
        }

        $courses = Course::getAll();
        $subjectAreas = SubjectArea::getAll();
        $allModules = Module::getAll();

        include __DIR__ . '/../Views/courses.php';
    }

    public function showSearchPage()
    {
        try {
            $subjectAreas = SubjectArea::getAll();
            $courseTypes = $this->getCourseTypes();

            $perPage = 10;
            $currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

            $searchResults = [];
            $searchPerformed = false;
            $totalPages = 0;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $searchPerformed = true;
                $searchResults = $this->performSearchPaginated($currentPage, $perPage);
                $totalPages = $searchResults['totalPages'] ?? 0;
                $searchResults = $searchResults['courses'] ?? [];
            }

            include __DIR__ . '/../Views/course-search.php';
        } catch (\Exception $e) {
            error_log('showSearchPage error: ' . $e->getMessage());
            include __DIR__ . '/../Views/404.php';
        }
    }

    private function performSearchPaginated($page, $perPage)
    {
        try {
            $subjectAreaId = isset($_POST['subject_area_id']) && $_POST['subject_area_id'] !== '' ? (int) $_POST['subject_area_id'] : null;
            $type = isset($_POST['type']) && $_POST['type'] !== '' ? trim($_POST['type']) : null;
            $minDuration = isset($_POST['min_duration']) && $_POST['min_duration'] !== '' ? (int) $_POST['min_duration'] : null;
            $maxDuration = isset($_POST['max_duration']) && $_POST['max_duration'] !== '' ? (int) $_POST['max_duration'] : null;
            $partTimeOnly = isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? true : null;

            if ($subjectAreaId === null && $type === null && $minDuration === null && $maxDuration === null && $partTimeOnly === null) {
                return ['courses' => [], 'totalPages' => 0];
            }

            $totalResults = Course::countSearchResults($subjectAreaId, $type, $minDuration, $maxDuration, $partTimeOnly);
            $totalPages = ceil($totalResults / $perPage);

            if ($page > $totalPages && $totalPages > 0) {
                $page = $totalPages;
            }

            $courses = Course::searchCoursesPaginated($page, $perPage, $subjectAreaId, $type, $minDuration, $maxDuration, $partTimeOnly);

            return [
                'courses' => $courses ?: [],
                'totalPages' => $totalPages,
                'totalResults' => $totalResults
            ];
        } catch (\Exception $e) {
            error_log('performSearchPaginated error: ' . $e->getMessage());
            return ['courses' => [], 'totalPages' => 0];
        }
    }

    private function performSearch()
    {
        try {
            $subjectAreaId = isset($_POST['subject_area_id']) && $_POST['subject_area_id'] !== '' ? (int) $_POST['subject_area_id'] : null;
            $type = isset($_POST['type']) && $_POST['type'] !== '' ? trim($_POST['type']) : null;
            $minDuration = isset($_POST['min_duration']) && $_POST['min_duration'] !== '' ? (int) $_POST['min_duration'] : null;
            $maxDuration = isset($_POST['max_duration']) && $_POST['max_duration'] !== '' ? (int) $_POST['max_duration'] : null;
            $partTimeOnly = isset($_POST['part_time_only']) && $_POST['part_time_only'] === 'on' ? true : null;

            if ($subjectAreaId === null && $type === null && $minDuration === null && $maxDuration === null && $partTimeOnly === null) {
                return [];
            }

            $courses = Course::searchCourses($subjectAreaId, $type, $minDuration, $maxDuration, $partTimeOnly);

            return $courses ?: [];
        } catch (\Exception $e) {
            error_log('performSearch error: ' . $e->getMessage());
            return [];
        }
    }

    private function getCourseTypes()
    {
        try {
            $sql = "SELECT DISTINCT type FROM courses ORDER BY type ASC";
            $statement = Database::query($sql, []);
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $types = [];
            foreach ($results as $row) {
                if (!empty($row['type'])) {
                    $types[] = $row['type'];
                }
            }
            return $types;
        } catch (\Exception $e) {
            error_log('getCourseTypes error: ' . $e->getMessage());
            return [];
        }
    }
}

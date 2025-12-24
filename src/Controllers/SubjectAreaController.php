<?php

namespace App\Controllers;

use App\Models\SubjectArea;
use App\Models\Course;
use App\Helpers\Auth;

class SubjectAreaController
{
    private $error = '';
    private $success = '';

    public function listSubjectAreas()
    {
        Auth::requireLogin();

        $subjectAreas = SubjectArea::getAll();
        $editSubjectArea = null;

        if (isset($_GET['edit'])) {
            $editSubjectArea = SubjectArea::getById($_GET['edit']);
        }

        include __DIR__ . '/../Views/subject-areas.php';
    }

    public function showSubjectArea($id)
    {
        try {
            $subjectArea = SubjectArea::getById($id);

            if (!$subjectArea) {
                include __DIR__ . '/../Views/404.php';
                return;
            }

            $perPage = 10;
            $currentPage = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

            $totalCourses = Course::countBySubjectArea($id);
            $totalPages = ceil($totalCourses / $perPage);

            if ($currentPage > $totalPages && $totalPages > 0) {
                $currentPage = $totalPages;
            }

            $courses = Course::getCoursesBySubjectAreaPaginated($id, $currentPage, $perPage);

            include __DIR__ . '/../Views/subject-area-detail.php';
        } catch (\Exception $e) {
            error_log('showSubjectArea error: ' . $e->getMessage());
            include __DIR__ . '/../Views/404.php';
        }
    }

    public function saveSubjectArea()
    {
        Auth::requireLogin();

        $subjectAreaId = isset($_POST['id']) ? $_POST['id'] : null;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';

        if (empty($name)) {
            $this->error = 'Subject area name is required';
        } elseif (strlen($name) < 3) {
            $this->error = 'Subject area name must be at least 3 characters';
        } elseif (strlen($name) > 150) {
            $this->error = 'Subject area name must not exceed 150 characters';
        }

        if (empty($this->error)) {
            try {
                if ($subjectAreaId) {
                    SubjectArea::updateSubjectAreaName($subjectAreaId, $name);
                    ;
                    $this->success = 'Subject area updated successfully';
                } else {
                    SubjectArea::createSubjectArea($name, Auth::getUserId());
                    $this->success = 'Subject area created successfully';
                }
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate') !== false) {
                    $this->error = 'A subject area with this name already exists';
                } else {
                    $this->error = 'An error occurred: ' . $e->getMessage();
                }
            }
        }

        if (empty($this->error)) {
            header('Location: /subject-areas?message=' . urlencode($this->success));
            exit;
        }

        $subjectAreas = SubjectArea::getAll();
        $editSubjectArea = $subjectAreaId ? SubjectArea::getById($subjectAreaId) : null;

        include __DIR__ . '/../Views/subject-areas.php';
    }

    public function deleteSubjectArea($id)
    {
        Auth::requireLogin();

        try {
            $subjectArea = SubjectArea::getById($id);

            if (!$subjectArea) {
                $this->error = 'Subject area not found';
            } else {
                SubjectArea::deleteRecord($id);
                $this->success = 'Subject area deleted successfully';
                header('Location: /subject-areas?message=' . urlencode($this->success));
                exit;
            }
        } catch (\Exception $e) {
            error_log('deleteSubjectArea error: ' . $e->getMessage());
            $this->error = 'Error deleting subject area: ' . $e->getMessage();
        }

        $subjectAreas = SubjectArea::getAll();

        include __DIR__ . '/../Views/subject-areas.php';
    }
}

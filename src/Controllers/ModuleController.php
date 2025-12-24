<?php

namespace App\Controllers;

use App\Models\Module;
use App\Models\Database;
use App\Helpers\Auth;

class ModuleController
{
    private $error = '';
    private $success = '';

    public function listModules()
    {
        Auth::requireLogin();

        $modules = Module::getAll();
        $editModule = null;

        if (isset($_GET['edit'])) {
            $editId = (int) $_GET['edit'];
            $editModule = Module::getById($editId);
        }

        include __DIR__ . '/../Views/modules.php';
    }

    public function saveModule()
    {
        Auth::requireLogin();

        $moduleId = isset($_POST['id']) ? (int) $_POST['id'] : null;
        $code = isset($_POST['code']) ? strtoupper(trim($_POST['code'])) : '';
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';

        if (empty($code)) {
            $this->error = 'Module code is required';
        } elseif (strlen($code) < 3) {
            $this->error = 'Module code must be at least 3 characters';
        } elseif (strlen($code) > 50) {
            $this->error = 'Module code must not exceed 50 characters';
        } elseif (!preg_match('/^[A-Z0-9]+$/', $code)) {
            $this->error = 'Module code can only contain letters and numbers';
        } elseif (empty($title)) {
            $this->error = 'Module title is required';
        } elseif (strlen($title) < 3) {
            $this->error = 'Module title must be at least 3 characters';
        } elseif (strlen($title) > 255) {
            $this->error = 'Module title must not exceed 255 characters';
        } elseif (empty($description)) {
            $this->error = 'Module description is required';
        }

        if (empty($this->error) && (!$moduleId || Module::getById($moduleId)['code'] !== $code)) {
            $existingModule = $this->getModuleByCode($code);
            if ($existingModule) {
                $this->error = 'A module with this code already exists';
            }
        }

        if (empty($this->error)) {
            try {
                if ($moduleId) {
                    Module::updateRecord($moduleId, [
                        'code' => $code,
                        'title' => $title,
                        'description' => $description
                    ]);
                    $this->success = 'Module updated successfully';
                } else {
                    Module::create([
                        'code' => $code,
                        'title' => $title,
                        'description' => $description
                    ]);
                    $this->success = 'Module created successfully';
                }

                header('Location: /modules?message=' . urlencode($this->success));
                exit;
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate') !== false) {
                    $this->error = 'A module with this code already exists';
                } else {
                    $this->error = 'An error occurred: ' . $e->getMessage();
                }
                error_log('saveModule error: ' . $e->getMessage());
            }
        }

        $modules = Module::getAll();
        $editModule = $moduleId ? Module::getById($moduleId) : null;

        include __DIR__ . '/../Views/modules.php';
    }

    public function deleteModule($id)
    {
        Auth::requireLogin();

        try {
            $module = Module::getById($id);

            if (!$module) {
                $this->error = 'Module not found';
            } else {
                $courseCount = $this->countCoursesWithModule($id);
                if ($courseCount > 0) {
                    $this->error = "Cannot delete this module - it is assigned to $courseCount course(s). Remove it from those courses first.";
                } else {
                    Module::deleteRecord($id);
                    $this->success = 'Module deleted successfully';
                    header('Location: /modules?message=' . urlencode($this->success));
                    exit;
                }
            }
        } catch (\Exception $e) {
            error_log('deleteModule error: ' . $e->getMessage());
            $this->error = 'Error deleting module: ' . $e->getMessage();
        }

        $modules = Module::getAll();
        $editModule = null;

        include __DIR__ . '/../Views/modules.php';
    }

    private function getModuleByCode($code)
    {
        try {
            $sql = "SELECT * FROM modules WHERE code = ?";
            $statement = Database::query($sql, [$code]);
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            error_log('getModuleByCode error: ' . $e->getMessage());
            return null;
        }
    }

    private function countCoursesWithModule($moduleId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM course_modules WHERE module_id = ?";
            $statement = Database::query($sql, [$moduleId]);
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch (\Exception $e) {
            error_log('countCoursesWithModule error: ' . $e->getMessage());
            return 0;
        }
    }
}

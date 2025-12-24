<?php

namespace App\Controllers;

use App\Models\Enquiry;
use App\Models\Course;
use App\Models\Database;
use App\Helpers\Auth;

class EnquiryController
{
    public function showForm()
    {
        $courses = Course::getAll();
        require __DIR__ . '/../Views/enquiry.php';
    }

    public function saveEnquiry()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Method not allowed');
        }

        $errors = [];

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $course_id = isset($_POST['course_id']) ? (int) $_POST['course_id'] : null;
        $message = trim($_POST['message'] ?? '');

        if (empty($name)) {
            $errors[] = 'Name is required';
        } elseif (strlen($name) > 150) {
            $errors[] = 'Name must not exceed 150 characters';
        }

        if (empty($email)) {
            $errors[] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid email address';
        } elseif (strlen($email) > 120) {
            $errors[] = 'Email must not exceed 120 characters';
        }

        if (!empty($phone) && strlen($phone) > 20) {
            $errors[] = 'Phone number must not exceed 20 characters';
        }

        if (empty($course_id)) {
            $errors[] = 'Please select a course';
        } else {
            $course = Course::getById($course_id);
            if (!$course) {
                $errors[] = 'Selected course does not exist';
            }
        }

        if (empty($message)) {
            $errors[] = 'Enquiry message is required';
        } elseif (strlen($message) < 10) {
            $errors[] = 'Enquiry message must be at least 10 characters';
        }

        if (!empty($errors)) {
            $courses = Course::getAll();
            $error = implode('<br>', $errors);
            require __DIR__ . '/../Views/enquiry.php';
            return;
        }

        try {
            Enquiry::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'course_id' => $course_id,
                'message' => $message,
                'status' => 'new',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /enquiry?message=' . urlencode('Thank you! We have received your enquiry and will respond soon.'));
            exit;
        } catch (\Exception $e) {
            $courses = Course::getAll();
            $error = 'An error occurred while saving your enquiry. Please try again.';
            error_log('Enquiry save error: ' . $e->getMessage());
            require __DIR__ . '/../Views/enquiry.php';
        }
    }

    public function listEnquiries()
    {
        Auth::requireLogin();

        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $enquiries = [];

        try {
            if ($filter === 'pending') {
                $enquiries = Enquiry::findAllBy('status', 'new');
            } elseif ($filter === 'responded') {
                $stmt = Database::query(
                    'SELECT * FROM enquiries WHERE status IN ("responded", "closed") ORDER BY responded_at DESC, created_at DESC'
                );
                $enquiries = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                $enquiries = Enquiry::getAll();
                usort($enquiries, function ($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
            }

            $enquiries = array_map(function ($enquiry) {
                $course = Course::getById($enquiry['course_id']);
                $enquiry['course_title'] = $course ? $course['title'] : 'Unknown Course';

                if (!empty($enquiry['responded_by'])) {
                    $stmt = Database::query(
                        'SELECT username FROM users WHERE id = ?',
                        [$enquiry['responded_by']]
                    );
                    $responder = $stmt->fetch(\PDO::FETCH_ASSOC);
                    $enquiry['responder_name'] = $responder ? $responder['username'] : 'Unknown User';
                }

                return $enquiry;
            }, $enquiries);
        } catch (\Exception $e) {
            error_log('List enquiries error: ' . $e->getMessage());
            $enquiries = [];
        }

        require __DIR__ . '/../Views/enquiries.php';
    }

    public function showEnquiry($id)
    {
        Auth::requireLogin();

        $enquiry = Enquiry::getById($id);
        if (!$enquiry) {
            http_response_code(404);
            require __DIR__ . '/../Views/404.php';
            return;
        }

        $course = Course::getById($enquiry['course_id']);
        $enquiry['course_title'] = $course ? $course['title'] : 'Unknown Course';

        if (!empty($enquiry['responded_by'])) {
            $stmt = Database::query(
                'SELECT username FROM users WHERE id = ?',
                [$enquiry['responded_by']]
            );
            $responder = $stmt->fetch(\PDO::FETCH_ASSOC);
            $enquiry['responder_name'] = $responder ? $responder['username'] : 'Unknown User';
        }

        require __DIR__ . '/../Views/enquiry-detail.php';
    }

    public function markResponded($id)
    {
        Auth::requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            die('Method not allowed');
        }

        $enquiry = Enquiry::getById($id);
        if (!$enquiry) {
            http_response_code(404);
            die('Enquiry not found');
        }

        try {
            $userId = Auth::getUserId();
            Enquiry::updateRecord($id, [
                'status' => 'responded',
                'responded_by' => $userId,
                'responded_at' => date('Y-m-d H:i:s')
            ]);

            header('Location: /admin/enquiries?message=' . urlencode('Enquiry marked as responded'));
            exit;
        } catch (\Exception $e) {
            error_log('Mark responded error: ' . $e->getMessage());
            header('Location: /admin/enquiries?error=' . urlencode('An error occurred'));
            exit;
        }
    }

    public function deleteEnquiry($id)
    {
        Auth::requireLogin();

        $enquiry = Enquiry::getById($id);
        if (!$enquiry) {
            http_response_code(404);
            require __DIR__ . '/../Views/404.php';
            return;
        }

        try {
            Enquiry::deleteRecord($id);
            header('Location: /admin/enquiries?message=' . urlencode('Enquiry deleted'));
            exit;
        } catch (\Exception $e) {
            error_log('Delete enquiry error: ' . $e->getMessage());
            header('Location: /admin/enquiries?error=' . urlencode('An error occurred'));
            exit;
        }
    }
}

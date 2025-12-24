<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Auth;

class UserController
{
    public function listUsers()
    {
        Auth::requireSuperAdmin();

        $users = User::getAll();
        $message = null;
        $error = null;

        if (isset($_GET['message'])) {
            if ($_GET['message'] === 'created') {
                $message = 'User created successfully';
            } elseif ($_GET['message'] === 'deleted') {
                $message = 'User deleted successfully';
            }
        }

        require __DIR__ . '/../Views/users.php';
    }

    public function createUser()
    {
        Auth::requireSuperAdmin();

        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Username and password are required';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match';
            } elseif (strlen($password) < 6) {
                $error = 'Password must be at least 6 characters';
            } else {
                $existingUser = User::getUserByUsername($username);
                
                if ($existingUser) {
                    $error = 'Username already exists';
                } else {
                    try {
                        User::createUser($username, $password, 'staff');
                        Auth::redirect('/users?message=created');
                    } catch (\Exception $e) {
                        $error = 'Error creating user: ' . $e->getMessage();
                    }
                }
            }
        }

        require __DIR__ . '/../Views/create-user.php';
    }

    public function deleteUser()
    {
        Auth::requireSuperAdmin();

        $userId = $_GET['id'] ?? null;
        $error = null;

        if (!$userId) {
            http_response_code(404);
            die('User ID not provided');
        }

        if ($userId == 1) {
            $error = 'Cannot delete the superadmin account';
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $result = User::deleteRecord($userId);
                
                if ($result > 0) {
                    Auth::redirect('/users?message=deleted');
                } else {
                    $error = 'User not found';
                }
            } catch (\Exception $e) {
                $error = 'Error deleting user: ' . $e->getMessage();
            }
        }

        $user = User::getById($userId);

        if (!$user) {
            http_response_code(404);
            die('User not found');
        }

        require __DIR__ . '/../Views/delete-user.php';
    }
}

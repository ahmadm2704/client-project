<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\Auth;

class AuthController
{
    public function loginPage()
    {
        if (Auth::isLoggedIn()) {
            Auth::redirect('/admin');
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = 'Username and password are required';
            } else {
                $user = User::authenticateUser($username, $password);

                if ($user) {
                    Auth::login($user);
                    Auth::redirect('/admin');
                } else {
                    $error = 'Invalid username or password';
                }
            }
        }

        require __DIR__ . '/../Views/login.php';
    }

    public function logout()
    {
        Auth::logout();
        Auth::redirect('/login?message=logged_out');
    }
}

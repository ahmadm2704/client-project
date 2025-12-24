<?php

namespace App\Helpers;

class Auth
{
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_STAFF = 'staff';

    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($user)
    {
        self::startSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
    }

    public static function logout()
    {
        self::startSession();
        session_destroy();
        session_unset();
    }

    public static function isLoggedIn()
    {
        self::startSession();
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    public static function getUser()
    {
        self::startSession();
        
        if (!self::isLoggedIn()) {
            return null;
        }

        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['role'] ?? null
        ];
    }

    public static function getUserId()
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getUsername()
    {
        self::startSession();
        return $_SESSION['username'] ?? null;
    }

    public static function getRole()
    {
        self::startSession();
        return $_SESSION['role'] ?? null;
    }

    public static function isSuperAdmin()
    {
        return self::getRole() === self::ROLE_SUPERADMIN;
    }

    public static function isStaff()
    {
        return self::getRole() === self::ROLE_STAFF;
    }

    public static function requireLogin()
    {
        if (!self::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }

    public static function requireSuperAdmin()
    {
        self::requireLogin();
        
        if (!self::isSuperAdmin()) {
            http_response_code(403);
            die('Access Denied: Superadmin privilege required');
        }
    }

    public static function requireStaffOrAdmin()
    {
        self::requireLogin();
    }

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function setFlash($key, $value)
    {
        self::startSession();
        $_SESSION['flash'][$key] = $value;
    }

    public static function getFlash($key)
    {
        self::startSession();
        
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $value;
        }

        return null;
    }
}

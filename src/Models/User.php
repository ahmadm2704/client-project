<?php

namespace App\Models;

class User extends BaseModel
{
    protected static $table = 'users';

    public static function authenticateUser($username, $password)
    {
        try {
            $user = static::findBy('username', $username);
            
            if (!$user) {
                return null;
            }

            if (password_verify($password, $user['password'])) {
                return $user;
            }

            return null;
        } catch (\Exception $e) {
            error_log('authenticateUser error: ' . $e->getMessage());
            return null;
        }
    }

    public static function getUserByUsername($username)
    {
        try {
            return static::findBy('username', $username);
        } catch (\Exception $e) {
            error_log('getUserByUsername error: ' . $e->getMessage());
            return null;
        }
    }

    public static function createUser($username, $password, $role = 'staff')
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            return static::create([
                'username' => $username,
                'password' => $hashedPassword,
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            error_log('createUser error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function getUsersByRole($role)
    {
        try {
            return static::findAllBy('role', $role);
        } catch (\Exception $e) {
            error_log('getUsersByRole error: ' . $e->getMessage());
            return [];
        }
    }

    public static function updateUserPassword($userId, $newPassword)
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            
            return static::updateRecord($userId, [
                'password' => $hashedPassword
            ]);
        } catch (\Exception $e) {
            error_log('updateUserPassword error: ' . $e->getMessage());
            throw $e;
        }
    }
}

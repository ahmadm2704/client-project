<?php

namespace App\Models;

class Module extends BaseModel
{
    protected static $table = 'modules';

    public static function getModuleByCode($code)
    {
        try {
            return static::findBy('code', $code);
        } catch (\Exception $e) {
            error_log('getModuleByCode error: ' . $e->getMessage());
            return null;
        }
    }

    public static function createModule($code, $title, $description)
    {
        try {
            return static::create([
                'code' => $code,
                'title' => $title,
                'description' => $description
            ]);
        } catch (\Exception $e) {
            error_log('createModule error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function searchByTitle($keyword)
    {
        try {
            $table = static::getTable();
            $sql = "SELECT * FROM $table WHERE title LIKE ?";
            $statement = Database::query($sql, ['%' . $keyword . '%']);
            return $statement->fetchAll();
        } catch (\Exception $e) {
            error_log('searchByTitle error: ' . $e->getMessage());
            return [];
        }
    }
}

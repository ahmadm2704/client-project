<?php

namespace App\Models;

abstract class BaseModel
{
    protected static $table;

    public static function setTable($tableName)
    {
        static::$table = $tableName;
    }

    public static function getTable()
    {
        if (!static::$table) {
            throw new \Exception('Table name not defined for ' . static::class);
        }
        return static::$table;
    }

    public static function getAll()
    {
        try {
            $table = static::getTable();
            return Database::select($table);
        } catch (\Exception $e) {
            error_log('getAll error: ' . $e->getMessage());
            return [];
        }
    }

    public static function getById($id)
    {
        try {
            $table = static::getTable();
            return Database::selectOne($table, ['id'], [$id]);
        } catch (\Exception $e) {
            error_log('getById error: ' . $e->getMessage());
            return null;
        }
    }

    public static function create($data)
    {
        try {
            $table = static::getTable();
            
            if (empty($data) || !is_array($data)) {
                throw new \Exception('Invalid data for insert');
            }

            return Database::insert($table, $data);
        } catch (\Exception $e) {
            error_log('create error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function updateRecord($id, $data)
    {
        try {
            $table = static::getTable();
            
            if (empty($data) || !is_array($data)) {
                throw new \Exception('Invalid data for update');
            }

            if (!$id) {
                throw new \Exception('ID is required for update');
            }

            return Database::update($table, $id, $data);
        } catch (\Exception $e) {
            error_log('updateRecord error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function deleteRecord($id)
    {
        try {
            $table = static::getTable();
            
            if (!$id) {
                throw new \Exception('ID is required for delete');
            }

            return Database::delete($table, $id);
        } catch (\Exception $e) {
            error_log('deleteRecord error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function count()
    {
        try {
            $table = static::getTable();
            return Database::count($table);
        } catch (\Exception $e) {
            error_log('count error: ' . $e->getMessage());
            return 0;
        }
    }

    public static function findBy($column, $value)
    {
        try {
            $table = static::getTable();
            return Database::selectOne($table, [$column], [$value]);
        } catch (\Exception $e) {
            error_log('findBy error: ' . $e->getMessage());
            return null;
        }
    }

    public static function findAllBy($column, $value)
    {
        try {
            $table = static::getTable();
            return Database::select($table, [$column], [$value]);
        } catch (\Exception $e) {
            error_log('findAllBy error: ' . $e->getMessage());
            return [];
        }
    }
}

<?php

namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static $connection;

    public static function connect()
    {
        if (self::$connection === null) {
            try {
                $host = DB_HOST;
                $name = DB_NAME;
                $user = DB_USER;
                $pass = DB_PASS;
                $port = DB_PORT;

                $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
                
                self::$connection = new PDO(
                    $dsn,
                    $user,
                    $pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }

        return self::$connection;
    }

    public static function query($sql, $params = [])
    {
        try {
            $connection = self::connect();
            $statement = $connection->prepare($sql);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            throw new PDOException('Query error: ' . $e->getMessage());
        }
    }

    public static function execute($sql, $params = [])
    {
        return self::query($sql, $params);
    }

    public static function select($table, $where = [], $params = [])
    {
        try {
            $sql = "SELECT * FROM $table";

            if (!empty($where)) {
                $conditions = [];
                foreach ($where as $column) {
                    $conditions[] = "$column = ?";
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $statement = self::query($sql, $params);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            throw new PDOException('Select error: ' . $e->getMessage());
        }
    }

    public static function selectOne($table, $where = [], $params = [])
    {
        try {
            $sql = "SELECT * FROM $table";

            if (!empty($where)) {
                $conditions = [];
                foreach ($where as $column) {
                    $conditions[] = "$column = ?";
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " LIMIT 1";
            $statement = self::query($sql, $params);
            return $statement->fetch();
        } catch (PDOException $e) {
            throw new PDOException('SelectOne error: ' . $e->getMessage());
        }
    }

    public static function insert($table, $data)
    {
        try {
            $columns = array_keys($data);
            $placeholders = array_fill(0, count($columns), '?');
            
            $sql = "INSERT INTO $table (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $values = array_values($data);
            
            $statement = self::query($sql, $values);
            return [
                'id' => self::connect()->lastInsertId(),
                'rows' => $statement->rowCount()
            ];
        } catch (PDOException $e) {
            throw new PDOException('Insert error: ' . $e->getMessage());
        }
    }

    public static function update($table, $id, $data)
    {
        try {
            $columns = array_keys($data);
            $sets = [];
            
            foreach ($columns as $column) {
                $sets[] = "$column = ?";
            }

            $sql = "UPDATE $table SET " . implode(', ', $sets) . " WHERE id = ?";
            $values = array_values($data);
            $values[] = $id;

            $statement = self::query($sql, $values);
            return $statement->rowCount();
        } catch (PDOException $e) {
            throw new PDOException('Update error: ' . $e->getMessage());
        }
    }

    public static function delete($table, $id)
    {
        try {
            $sql = "DELETE FROM $table WHERE id = ?";
            $statement = self::query($sql, [$id]);
            return $statement->rowCount();
        } catch (PDOException $e) {
            throw new PDOException('Delete error: ' . $e->getMessage());
        }
    }

    public static function count($table, $where = [], $params = [])
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM $table";

            if (!empty($where)) {
                $conditions = [];
                foreach ($where as $column) {
                    $conditions[] = "$column = ?";
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $statement = self::query($sql, $params);
            $result = $statement->fetch();
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            throw new PDOException('Count error: ' . $e->getMessage());
        }
    }
}

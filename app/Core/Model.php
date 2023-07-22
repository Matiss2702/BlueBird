<?php

namespace App\Core;

abstract class Model
{
    private static $pdo;

    protected $id;

    protected static $table;
    protected static $fillable = [];

    private static $db_dsn       = 'pgsql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT;
    private static $db_username  = DB_USERNAME;
    private static $db_password  = DB_PASSWORD;

    protected static function getPDO()
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new \PDO(
                    self::$db_dsn,
                    self::$db_username,
                    self::$db_password
                );
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                throw new \App\Exceptions\DatabaseException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return self::$pdo;
    }

    public static function all()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public static function find($id)
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            $model = new static();
            $model->fill($data);
            return $model;
        }

        return null;
    }

    public static function where($column, $operator, $value = null)
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $pdo = self::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE $column $operator :value");
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            $model = new static();
            $model->fill($data);
            return $model;
        }

        return null;
    }

    protected function fill(array $data)
    {
        foreach ($data as $key => $value) {
            // TODO
            /* désactivation pour investiguation : peut-être une source de problème
            if (in_array($key, static::$fillable)) {
                $this->{$key} = $value;
            }*/
            $this->{$key} = $value;

            if ($key === 'id') {
                $this->id = $value;
            }
        }
    }

    public function create()
    {
        $pdo = self::getPDO();
        $fields = [];
        $values = [];
        $placeholders = [];

        foreach (static::$fillable as $column) {
            $fields[] = $column;
            $values[] = $this->{$column};
            $placeholders[] = "?";
        }

        $fields = implode(', ', $fields);
        $placeholders = implode(', ', $placeholders);

        $stmt = $pdo->prepare("INSERT INTO " . static::$table . " ($fields) VALUES ($placeholders)");
        $stmt->execute($values);

        return $pdo->lastInsertId();
    }

    public function update()
    {
        $pdo = self::getPDO();
        $fields = [];
        $values = [];

        foreach (static::$fillable as $column) {
            $fields[] = "$column = ?";
            $values[] = $this->{$column};
        }

        $values[] = $this->id;

        $fields = implode(', ', $fields);

        $stmt = $pdo->prepare("UPDATE " . static::$table . " SET $fields WHERE id = ?");
        $stmt->execute($values);
    }

    public function delete()
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
    }

}

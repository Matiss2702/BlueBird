<?php

namespace App\Models;

use PDOException;

class DatabaseModel
{
    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbHost = 'localhost';
    private $dbPort = '5432';
    private $tablePrefix;
    private $pdo;

    public function __construct() {}

    public function getPdo()
    {
        return $this->pdo;
    }

    public function initTables($db_prefix)
    {
        if (!$this->pdo) {
            throw new \App\Exceptions\DatabaseException('La connexion à la base de données n\'a pas été initialisée.');
        }

        // TODO : mettre la vrai BD
        $query = "CREATE TABLE IF NOT EXISTS " . $db_prefix . "test_installeur (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    description TEXT
                )";

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    public function initPdo()
    {
        $dsn = 'pgsql:host='.$this->dbHost.';dbname=' . $this->dbName . ';port='.$this->dbPort;

        try {
            $pdo = new \PDO(
                $dsn,
                $this->dbUser,
                $this->dbPassword
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }
        $this->pdo = $pdo;
        return true;
    }

    public function getDbName(): string
    {
        return $this->dbName;
    }

    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    public function setDbUser(string $dbUser): void
    {
        $this->dbUser = $dbUser;
    }

    public function getDbPassword(): string
    {
        return $this->dbPassword;
    }

    public function setDbPassword(string $dbPassword): void
    {
        $this->dbPassword = $dbPassword;
    }

    public function getDbHost(): string
    {
        return $this->dbHost;
    }

    public function setDbHost(string $dbHost): void
    {
        $this->dbHost = $dbHost;
    }

    public function getDbPort(): string
    {
        return $this->dbPort;
    }

    public function setDbPort(string $dbPort): void
    {
        $this->dbPort = $dbPort;
    }

    public function getTablePrefix(): string
    {
        return $this->tablePrefix;
    }

    public function setTablePrefix(string $tablePrefix): void
    {
        $this->tablePrefix = $tablePrefix;
    }

    public function createDatabase(): bool
    {
        if ($this->databaseExists()) {
            return false;
        }

        try {
            // Créer la base de données
            $stmtCreateDb = $this->pdo->prepare("CREATE DATABASE :dbName");
            $stmtCreateDb->bindParam(':dbName', $this->dbName);
            $stmtCreateDb->execute();

            // Créer un utilisateur avec les privilèges sur la base de données
            $stmtCreateUser = $this->pdo->prepare("GRANT ALL PRIVILEGES ON DATABASE :dbName TO :dbUser");
            $stmtCreateUser->bindParam(':dbName', $this->dbName);
            $stmtCreateUser->bindParam(':dbUser', $this->dbUser);
            $stmtCreateUser->execute();

            return true;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }
    
    private function databaseExists(): bool
    {
        try {
            $stmt = $this->pdo->prepare("SELECT datname FROM pg_catalog.pg_database WHERE datname = :dbName");
            $stmt->bindParam(':dbName', $this->dbName);
            $stmt->execute();

            return ($stmt->fetchColumn() !== false);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}
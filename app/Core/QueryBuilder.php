<?php

namespace App\Core;

use PDO;
use PDOException;

class QueryBuilder
{
    private static $pdo;
    private static $table;
    private static $prefix = DB_PREFIX;
    private static $db_dsn       = 'pgsql:host='.DB_HOST.';dbname='.DB_DATABASE.';port='.DB_PORT;
    private static $db_username  = DB_USERNAME;
    private static $db_password  = DB_PASSWORD;

    protected $selects = [];
    protected $wheres = [];
    protected $joins = [];
    protected $distinct = false;
    protected $updates = [];
    protected $limit = null;
    protected $orWheres = [];
    protected $andWheres = [];
    protected $havings = [];
    protected $orderBy = [];
    protected $groupBy = [];
    protected $offset = null;


    /**
     * @param string $table Le nom de la table principale
     */
    public function __construct(string $table)
    {
        self::$table = self::$prefix . $table;
    }

    /**
     * Obtient une instance de la connexion PDO.
     *
     * @return PDO L'objet PDO
     */
    protected static function getPDO()
    {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO(
                    self::$db_dsn,
                    self::$db_username,
                    self::$db_password
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
            }
        }

        return self::$pdo;
    }

    /**
     * Définit la table principale de la requête.
     *
     * @param string $table Le nom de la table principale
     * @return QueryBuilder L'instance de QueryBuilder
     */
    public static function table(string $table): self
    {
        return new static($table);
    }

    /**
     * Sélectionne les colonnes à récupérer.
     *
     * @param ...$fields Les colonnes à sélectionner
     * @return self L'instance de QueryBuilder
     */
    public function select($fields = [], $tableAliases = []): self
    {
        $prefixedFields = [];

        foreach ($fields as $field) {
            $prefixedFields[] = $this->prefixColumnName($field);
        }

        $this->selects = array_merge($this->selects, $prefixedFields);

        return $this;
    }

    /**
     * Ajoute une clause DISTINCT à la requête.
     *
     * @return self L'instance de QueryBuilder
     */
    public function distinct(): self
    {
        $this->distinct = true;
        return $this;
    }

    public function join(string $table, ?\Closure $callback = null, ?string $alias = null, string $type = 'INNER'): self
    {
        $joinClause = new JoinClause($type, $table, $alias);

        if ($callback) {
            $callback($joinClause);
        }

        $this->joins[] = $joinClause;

        return $this;
    }

    public function leftJoin(string $table, ?\Closure $callback = null, ?string $alias = null): self
    {
        return $this->join($table, $callback, $alias, 'LEFT');
    }

    public function rightJoin(string $table, ?\Closure $callback = null, ?string $alias = null): self
    {
        return $this->join($table, $callback, $alias, 'RIGHT');
    }

    /**
     * Ajoute une clause WHERE à la requête.
     *
     * @param $field Le champ à comparer
     * @param $operator L'opérateur de comparaison
     * @param $value La valeur à comparer
     * @return self L'instance de QueryBuilder
     */
    public function where($field, $operator, $value = null): self
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $field = $this->prefixColumnName($field);
        $this->wheres[] = compact('field', 'operator', 'value');

        return $this;
    }

    /**
     * Ajoute une clause OR WHERE à la requête.
     *
     * @param $field Le champ à comparer
     * @param $operator L'opérateur de comparaison
     * @param $value La valeur à comparer
     * @return self L'instance de QueryBuilder
     */
    public function orWhere($field, $operator, $value = null): self
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $field = $this->prefixColumnName($field);
        $this->orWheres[] = compact('field', 'operator', 'value');

        return $this;
    }

    /**
     * Ajoute une clause WHERE IS NULL à la requête.
     *
     * @param string $field Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function whereNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NULL';

        $this->wheres[] = compact('field', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause WHERE IS NOT NULL à la requête.
     *
     * @param string $field Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function whereNotNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NOT NULL';

        $this->wheres[] = compact('field', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause AND WHERE IS NULL à la requête.
     *
     * @param string $field Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function andWhereNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NULL';

        $this->andWheres[] = compact('field', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause AND WHERE IS NOT NULL à la requête.
     *
     * @param string $field Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function andWhereNotNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NOT NULL';

        $this->andWheres[] = compact('column', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause OR WHERE IS NULL à la requête.
     *
     * @param string $column Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function orWhereNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NULL';

        $this->orWheres[] = compact('field', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause OR WHERE IS NOT NULL à la requête.
     *
     * @param string $field Le nom de la colonne
     * @return self L'instance de QueryBuilder
     */
    public function orWhereNotNull(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $operator = 'IS NOT NULL';

        $this->orWheres[] = compact('field', 'operator');
        return $this;
    }

    /**
     * Ajoute une clause AND WHERE à la requête.
     *
     * @param $field Le champ à comparer
     * @param $operator L'opérateur de comparaison
     * @param $value La valeur à comparer
     * @return self L'instance de QueryBuilder
     */
    public function andWhere($field, $operator, $value = null): self
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $field = $this->prefixColumnName($field);
        $this->andWheres[] = compact('field', 'operator', 'value');

        return $this;
    }

    /**
     * Ajoute le préfixe de la base de données au champ si nécessaire.
     *
     * @param $column Le champ à préfixer
     * @return void
     */
    private function prefixColumnName($column)
    {
        if (strpos($column, '.') === false) {
            $column = self::$table . '.' . $column;
        } else {
            $parts = explode('.', $column);
            $table = $parts[0];
            $column = self::$prefix . $table . '.' . $parts[1];
        }

        return $column;
    }

    /**
     * Ajoute une clause LIMIT à la requête.
     *
     * @param int $limit Le nombre de résultats à limiter
     * @return self L'instance de QueryBuilder
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Ajoute une clause HAVING à la requête.
     *
     * @param $field Le champ à comparer
     * @param $operator L'opérateur de comparaison
     * @param $value La valeur à comparer
     * @return self L'instance de QueryBuilder
     */
    public function having($field, $operator, $value = null): self
    {
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = '=';
        }

        $field = $this->prefixColumnName($field);
        $this->havings[] = compact('field', 'operator', 'value');

        return $this;
    }

    /**
     * Ajoute une clause ORDER BY à la requête.
     *
     * @param string $field Le champ à trier
     * @param string $direction La direction de tri (ASC ou DESC)
     * @return self L'instance de QueryBuilder
     */
    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $field = $this->prefixColumnName($field);
        $this->orderBy[] = compact('field', 'direction');

        return $this;
    }

    /**
     * Ajoute une clause GROUP BY à la requête.
     *
     * @param string $field Le champ à regrouper
     * @return self L'instance de QueryBuilder
     */
    public function groupBy(string $field): self
    {
        $field = $this->prefixColumnName($field);
        $this->groupBy[] = $field;

        return $this;
    }

    /**
     * Ajoute une clause OFFSET à la requête.
     *
     * @param int $offset L'offset à utiliser
     * @return self L'instance de QueryBuilder
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Exécute la requête et récupère les résultats.
     *
     * @return mixed Les résultats de la requête
     */
    public function get()
    {
        try {
            $sql = 'SELECT ';

            if ($this->distinct) {
                $sql .= 'DISTINCT ';
            }

            $sql .= $this->selects ? implode(', ', $this->selects) : '*';
            $sql .= ' FROM ' .  self::$table;

            foreach ($this->joins as $join) {
                $sql .= ' ' . $join->getJoinType() . ' JOIN ' . $join->getTable();

                if ($join->getAlias()) {
                    $sql .= ' AS ' . $join->getAlias();
                }

                $onClauses = $join->getOnClauses();
                if (!empty($onClauses)) {
                    $sql .= ' ON ';

                    $firstOnClause = array_shift($onClauses);
                    $sql .= $firstOnClause['column1'] . ' ' . $firstOnClause['operator'] . ' ' . $firstOnClause['column2'];

                    foreach ($onClauses as $onClause) {
                        $sql .= ' AND ' . $onClause['column1'] . ' ' . $onClause['operator'] . ' ' . $onClause['column2'];
                    }
                }
            }

            if ($this->wheres) {
                $sql .= ' WHERE ';
                $sql .= implode(' AND ', array_map(function ($where) {
                    if (in_array($where['operator'], ['IS NULL', 'IS NOT NULL'])) {
                        return $where['field'] . ' ' . $where['operator'];
                    }
                    else {
                        return $where['field'] . ' ' . $where['operator'] . ' ?';
                    }
                }, $this->wheres));
            }
            
            if ($this->orWheres) {
                $sql .= ' OR ';
                $sql .= implode(' OR ', array_map(function ($where) {
                    if (in_array($where['operator'], ['IS NULL', 'IS NOT NULL'])) {
                        return $where['field'] . ' ' . $where['operator'];
                    }
                    else {
                        return $where['field'] . ' ' . $where['operator'] . ' ?';
                    }
                }, $this->orWheres));
            }

            if ($this->andWheres) {
                $sql .= ' AND ';
                $sql .= implode(' AND ', array_map(function ($where) {
                    if (in_array($where['operator'], ['IS NULL', 'IS NOT NULL'])) {
                        return $where['field'] . ' ' . $where['operator'];
                    }
                    else {
                        return $where['field'] . ' ' . $where['operator'] . ' ?';
                    }
                }, $this->andWheres));
            }

            if ($this->groupBy) {
                $sql .= ' GROUP BY ';
                $sql .= implode(', ', $this->groupBy);
            }

            if ($this->havings) {
                $sql .= ' HAVING ';
                $sql .= implode(' AND ', array_map(function ($having) {
                    return $having['field'] . ' ' . $having['operator'] . ' ?';
                }, $this->havings));
            }

            if ($this->orderBy) {
                $sql .= ' ORDER BY ';
                $sql .= implode(', ', array_map(function ($order) {
                    return $order['field'] . ' ' . $order['direction'];
                }, $this->orderBy));
            }
            
            if ($this->limit) {
                $sql .= ' LIMIT ' . $this->limit;
            }

            if ($this->offset) {
                $sql .= ' OFFSET ' . $this->offset;
            }

            $stmt = self::getPDO()->prepare($sql);

            $values = [];
            foreach ($this->wheres as $where) {
                if  (isset($where['value'])) {
                    $values[] = $where['value'];
                }
            }

            foreach ($this->orWheres as $where) {
                if  (isset($where['value'])) {
                    $values[] = $where['value'];
                }
            }

            foreach ($this->andWheres as $where) {
                if  (isset($where['value'])) {
                    $values[] = $where['value'];
                }
            }

            foreach ($this->havings as $having) {
                $values[] = $having['value'];
            }

            $stmt->execute($values);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Récupère la valeur d'une colonne spécifique de la première ligne du résultat.
     *
     * @param string $column Le nom de la colonne à récupérer
     * @return mixed La valeur de la colonne ou null si la colonne n'existe pas
     */
    public function getColumn(string $column)
    {
        $result = $this->get();
        if ($result && isset($result[0][$column])) {
            return $result[0][$column];
        }
        return null;
    }

    
    /**
     * Vérifie si la requête retourne des résultats.
     *
     * @return bool Vrai si des résultats sont retournés, sinon faux
     */
    public function exists(): bool
    {
        try {
            $this->limit(1);
            $result = $this->get();

            return (bool)$result;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Vérifie si la requête ne retourne aucun résultat.
     *
     * @return bool Vrai si aucun résultat n'est retourné, sinon faux
     */
    public function notExists(): bool
    {
        try {
            $this->limit(1);
            $result = $this->get();

            return !(bool)$result;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Récupère uniquement le premier résultat de la requête.
     *
     * @return mixed Le premier résultat de la requête
     */
    public function first()
    {
        try {
            $this->limit(1);
            $result = $this->get();

            if ($result && is_array($result)) {
                return $result[0];
            }

            return $result;
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Insère une ligne dans la base de données.
     *
     * @param array $data Les données à insérer
     */
    public function insert(array $data): bool
    {
        try {
            $fields = array_keys($data);
            $values = array_values($data);
            $placeholders = array_fill(0, count($fields), '?');

            $stmt = self::getPDO()->prepare(
                "INSERT INTO " . self::$table . " (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")"
            );

            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Insère une ou plusieurs lignes dans la base de données.
     *
     * @param array $data Les données à insérer
     * @return bool Vrai si l'insertion a réussi, sinon faux
     */
    public function insertMultiple(array $data)
    {
        if (empty($data)) {
            return;
        }

        $fields = array_keys($data[0]);
        $fields = implode(', ', $fields);

        $values = [];
        $placeholders = [];

        foreach ($data as $dataSet) {
            $rowValues = [];
            foreach ($dataSet as $value) {
                $rowValues[] = '?';
                $values[] = $value;
            }
            $placeholders[] = '(' . implode(', ', $rowValues) . ')';
        }

        $placeholders = implode(', ', $placeholders);

        $sql = "INSERT INTO ". static::$table . " ({$fields}) VALUES {$placeholders}";

        $stmt = $this->getPDO()->prepare($sql);
        $stmt->execute($values);
    }

    /**
     * Met à jour une ligne dans la base de données.
     *
     * @param array $data Les données à mettre à jour
     * @return bool Vrai si la mise à jour a réussi, sinon faux
     */
    public function update(array $data): bool
    {
        try {
            $fields = array_keys($data);
            $setClause = array_map(function ($field) {
                return "$field = ?";
            }, $fields);
            $values = array_values($data);

            $sql = "UPDATE " . self::$table . " SET " . implode(', ', $setClause);

            if ($this->wheres) {
                $sql .= ' WHERE ';
                $sql .= implode(' AND ', array_map(function ($where) {
                    return $where['field'] . ' ' . $where['operator'] . ' ?';
                }, $this->wheres));

                foreach ($this->wheres as $where) {
                    $values[] = $where['value'];
                }
            }

            $stmt = self::getPDO()->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }

    /**
     * Supprime une ligne de la base de données.
     *
     * @return bool Vrai si la suppression a réussi, sinon faux
     */
    public function delete(): bool
    {
        try {
            $sql = "DELETE FROM " . self::$table;
            $values = [];

            if ($this->wheres) {
                $sql .= ' WHERE ';
                $sql .= implode(' AND ', array_map(function ($where) {
                    return $where['field'] . ' ' . $where['operator'] . ' ?';
                }, $this->wheres));

                foreach ($this->wheres as $where) {
                    $values[] = $where['value'];
                }
            }

            $stmt = self::getPDO()->prepare($sql);
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new \App\Exceptions\DatabaseException((string)$e->getMessage(), (int)$e->getCode(), $e);
        }
    }
}

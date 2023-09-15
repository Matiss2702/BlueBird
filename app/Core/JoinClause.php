<?php

namespace App\Core;

class JoinClause
{
    protected $joinType;
    protected $table;
    protected $alias;
    protected $onClauses = [];

    public function __construct($joinType, $table, $alias = null)
    {
        $this->joinType = $joinType;
        $this->table = DB_PREFIX . $table;
        $this->alias = $alias ? (DB_PREFIX . $alias) : null;
    }

    public function on($column1, $operator, $column2, $addPrefix = true)
    {
        $column1 = DB_PREFIX . $column1;
        if ($addPrefix)
            $column2 = DB_PREFIX . $column2;

        $this->onClauses[] = compact('column1', 'operator', 'column2');
        return $this;
    }

    public function getJoinType()
    {
        return $this->joinType;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getOnClauses()
    {
        return $this->onClauses;
    }
}

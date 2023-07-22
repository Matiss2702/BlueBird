<?php

namespace App\Models;

use App\Core\Model;

class Role extends Model
{
    protected static $table = DB_PREFIX . 'role';
    protected static $fillable = ['name'];

    protected $id;

    protected $name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}

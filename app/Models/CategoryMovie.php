<?php

namespace App\Models;

use App\Core\Model;

class CategoryMovie extends Model
{
    protected static $table = DB_PREFIX . 'category_movie';
    protected static $fillable = ['name', 'created_at', 'updated_at'];

    protected $id;

    protected $name;
    protected $created_at;
    protected $updated_at;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        return $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
}
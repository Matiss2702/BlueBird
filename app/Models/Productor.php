<?php

namespace App\Models;

use App\Core\Model;

class Productor extends Model
{
    protected static $table = DB_PREFIX . 'productor';
    protected static $fillable = ['name', 'description', 'id_country'];

    protected $id;

    protected $name;
    protected $description;
    protected $id_country;

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getIdCountry() {
        return $this->id_country;
    }

    public function setIdCountry($id_country) {
        $this->id_country = $id_country;
    }
}
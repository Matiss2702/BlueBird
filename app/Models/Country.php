<?php

namespace App\Models;

use App\Core\Model;

class Country extends Model
{
    protected static $table = DB_PREFIX . 'country';
    protected static $fillable = ['iso','name','nicename','iso3','numcode','phonecode'];

    protected $id;

    protected $iso;
    protected $name;
    protected $nicename;
    protected $iso3;
    protected $numcode;
    protected $phonecode;

    public function getId() {
        return $this->id;
    }

    public function getIso() {
        return $this->iso;
    }

    public function setIso($iso) {
        $this->iso = $iso;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getNicename() {
        return $this->nicename;
    }

    public function setNicename($nicename) {
        $this->nicename = $nicename;
    }

    public function getIso3() {
        return $this->iso3;
    }

    public function setIso3($iso3) {
        $this->iso3 = $iso3;
    }

    public function getNumcode() {
        return $this->numcode;
    }

    public function setNumcode($numcode) {
        $this->numcode = $numcode;
    }

    public function getPhoneCode() {
        return $this->phonecode;
    }

    public function setPhoneCode($phonecode) {
        $this->phonecode = $phonecode;
    }
}
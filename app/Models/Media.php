<?php

namespace App\Models;

use App\Core\Model;

class Media extends Model
{
    protected static $table = DB_PREFIX . 'media';
    protected static $fillable = ['name','alt','slug', 'type','created_at','updated_at'];

    protected $id;

    protected $name;
    protected $alt;
    protected $slug;
    protected $type;
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

    public function getAlt() {
        return $this->alt;
    }

    public function setAlt($alt) {
        $this->alt = $alt;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }
}
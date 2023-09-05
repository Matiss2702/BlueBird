<?php

namespace App\Models;

use App\Core\Model;

class Memento extends Model
{
    protected static $table = DB_PREFIX . 'memento';
    protected static $fillable = ['title', 'slug', 'description','content', 'created_at', 'id_page'];

    protected $id;

    protected $title;
    protected $slug;
    protected $description;
    protected $content;
    protected $created_at;
    protected $id_page;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    public function getIdPage() {
        return $this->id_page;
    }

    public function setIdPage($id_page) {
        $this->id_page = $id_page;
    }
}

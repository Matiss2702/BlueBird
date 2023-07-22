<?php

namespace App\Models;

use App\Core\Model;

class Page extends Model
{
    protected static $table = DB_PREFIX . 'page';
    protected static $fillable = ['title', 'content', 'slug'];

    protected $id;

    protected $title;
    protected $content;
    protected $slug;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }
}

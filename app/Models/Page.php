<?php

namespace App\Models;

use App\Core\Model;

class Page extends Model
{
    protected static $table = DB_PREFIX . 'page';
    protected static $fillable = ['title', 'slug', 'description', 'content', 'is_home', 'created_at', 'updated_at'];

    protected $id;

    protected $title;
    protected $slug;
    protected $description;
    protected $content;
    protected $is_home;
    protected $created_at;
    protected $updated_at;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getIsHome()
    {
        return $this->is_home;
    }

    public function setIsHome($is_home)
    {
        $this->is_home = $is_home;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}

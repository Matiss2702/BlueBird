<?php

namespace App\Models;

use App\Core\Model;

class Page extends Model
{
    protected static $table = DB_PREFIX . 'page';
    protected static $fillable = ['header_title', 'header_description', 'main_title', 'main_content', 'sidebar_title', 'sidebar_content'];

    protected $id;

    protected $slug;
    protected $header_title;
    protected $header_description;
    protected $main_title;
    protected $main_content;
    protected $sidebar_title;
    protected $sidebar_content;

    public function getId()
    {
        return $this->id;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getHeaderTitle()
    {
        return $this->header_title;
    }

    public function setHeaderTitle($header_title)
    {
        $this->header_title = $header_title;
    }

    public function getHeaderDescription()
    {
        return $this->header_description;
    }

    public function setHeaderDescription($header_description)
    {
        $this->header_description = $header_description;
    }

    public function getMainTitle()
    {
        return $this->main_title;
    }

    public function setMainTitle($main_title)
    {
        $this->main_title = $main_title;
    }

    public function getMainContent()
    {
        return $this->main_content;
    }

    public function setMainContent($main_content)
    {
        $this->main_content = $main_content;
    }

    public function getSidebarTitle()
    {
        return $this->sidebar_title;
    }

    public function setSidebarTitle($sidebar_title)
    {
        $this->sidebar_title = $sidebar_title;
    }

    public function getSidebarContent()
    {
        return $this->sidebar_content;
    }

    public function setSidebarContent($sidebar_content)
    {
        $this->sidebar_content = $sidebar_content;
    }
}

<?php

namespace App\Models;

use App\Core\Model;

class TemplateOne extends Model
{
    protected static $table = DB_PREFIX . 'template_one';
    protected static $fillable = ['slug', 'title', 'subtitle', 'about_title', 'about_desc', 'about_img', 'main_bloc_title', 'main_bloc_desc', 'main_bloc_img', 'bloc_one_title', 'bloc_one_desc', 'bloc_one_img', 'bloc_two_title', 'bloc_two_desc', 'bloc_two_img', 'address', 'email', 'phone'];

    protected $id;
    protected $slug;
    protected $title;
    protected $subtitle;
    protected $about_title;
    protected $about_desc;
    protected $about_img;
    protected $main_bloc_title;
    protected $main_bloc_desc;
    protected $main_bloc_img;
    protected $bloc_one_title;
    protected $bloc_one_desc;
    protected $bloc_one_img;
    protected $bloc_two_title;
    protected $bloc_two_desc;
    protected $bloc_two_img;
    protected $address;
    protected $email;
    protected $phone;

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }

    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    public function getAboutTitle()
    {
        return $this->about_title;
    }

    public function setAboutTitle($about_title)
    {
        $this->about_title = $about_title;
    }

    public function getAboutDesc()
    {
        return $this->about_desc;
    }

    public function setAboutDesc($about_desc)
    {
        $this->about_desc = $about_desc;
    }

    public function getAboutImg()
    {
        return $this->about_img;
    }

    public function setAboutImg($about_img)
    {
        $this->about_img = $about_img;
    }

    public function getMainBlocTitle()
    {
        return $this->main_bloc_title;
    }

    public function setMainBlocTitle($main_bloc_title)
    {
        $this->main_bloc_title = $main_bloc_title;
    }

    public function getMainBlocDesc()
    {
        return $this->main_bloc_desc;
    }

    public function setMainBlocDesc($main_bloc_desc)
    {
        $this->main_bloc_desc = $main_bloc_desc;
    }

    public function getMainBlocImg()
    {
        return $this->main_bloc_img;
    }

    public function setMainBlocImg($main_bloc_img)
    {
        $this->main_bloc_img = $main_bloc_img;
    }

    public function getBlocOneTitle()
    {
        return $this->bloc_one_title;
    }

    public function setBlocOneTitle($bloc_one_title)
    {
        $this->bloc_one_title = $bloc_one_title;
    }

    public function getBlocOneDesc()
    {
        return $this->bloc_one_desc;
    }

    public function setBlocOneDesc($bloc_one_desc)
    {
        $this->bloc_one_desc = $bloc_one_desc;
    }

    public function getBlocOneImg()
    {
        return $this->bloc_one_img;
    }

    public function setBlocOneImg($bloc_one_img)
    {
        $this->bloc_one_img = $bloc_one_img;
    }

    public function getBlocTwoTitle()
    {
        return $this->bloc_two_title;
    }

    public function setBlocTwoTitle($bloc_two_title)
    {
        $this->bloc_two_title = $bloc_two_title;
    }

    public function getBlocTwoDesc()
    {
        return $this->bloc_two_desc;
    }

    public function setBlocTwoDesc($bloc_two_desc)
    {
        $this->bloc_two_desc = $bloc_two_desc;
    }

    public function getBlocTwoImg()
    {
        return $this->bloc_two_img;
    }

    public function setBlocTwoImg($bloc_two_img)
    {
        $this->bloc_two_img = $bloc_two_img;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}

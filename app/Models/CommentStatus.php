<?php

namespace App\Models;

use App\Core\Model;

class CommentStatus extends Model
{
    protected static $table = DB_PREFIX . 'comment_status';
    protected static $fillable = ['intitule'];

    protected $id;
    protected $intitule;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIntitule()
    {
        return $this->intitule;
    }

    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;
    }
}

<?php

namespace App\Models;

use App\Core\Model;

class CategorieMessage extends Model
{
    protected static $table = DB_PREFIX . 'categorie_message';
    protected static $fillable = ['description'];

    protected $id;
    protected String $description;


    public function getId()
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}

<?php

namespace App\Models;

use App\Core\Model;

class MovieCategoryMovie extends Model
{
    protected static $table = DB_PREFIX . 'movie_category_movie';
    protected static $fillable = ['id_movie', 'id_category_movie'];

    protected $id;

    protected $id_movie;
    protected $id_category_movie;
    protected $created_at;

    public function getId() {
        return $this->id;
    }

    public function getIdMovie() {
        return $this->id_movie;
    }

    public function setIdMovie($id_movie) {
        $this->id_movie = $id_movie;
    }

    public function getIdCategoryMovie() {
        return $this->id_category_movie;
    }

    public function setIdCategoryMovie($id_category_movie) {
        $this->id_category_movie = $id_category_movie;
    }
}
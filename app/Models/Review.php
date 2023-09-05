<?php

namespace App\Models;

use App\Core\Model;

class Review extends Model
{
    protected static $table = DB_PREFIX . 'review';
    protected static $fillable = [
        'rate',
        'comment',
        'id_movie',
        'id_user'
    ];

    protected $id;

    protected $rate;
    protected $comment;
    protected $id_movie;
    protected $id_user;

    public function getId() {
        return $this->id;
    }

    public function getRate() {
        return $this->rate;
    }

    public function setRate(int $rate) {
        $this->rate = $rate;
    }

    public function getComment() {
        return $this->comment;
    }

    public function setComment(string $comment) {
        $this->comment = $comment;
    }

    public function getIdMovie() {
        return $this->id_movie;
    }

    public function setIdMovie(int $id_movie) {
        $this->id_movie = $id_movie;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser(int $id_user) {
        $this->id_user = $id_user;
    }
}
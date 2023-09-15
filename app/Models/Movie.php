<?php

namespace App\Models;

use App\Core\Model;

class Movie extends Model
{
    protected static $table = DB_PREFIX . 'movie';
    protected static $fillable = ['title', 'description', 'release_date', 'duration', 'id_media', 'created_at', 'updated_at'];

    protected $id;

    protected $title;
    protected $description;
    protected $release_date;
    protected $duration;
    protected $id_media;
    protected $created_at;
    protected $updated_at;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getReleaseDate() {
        return $this->release_date;
    }

    public function getFormattedReleaseDate() {
        return date('d F Y', strtotime($this->release_date));
    }

    public function setReleaseDate($release_date) {
        $this->release_date = $release_date;
    }

    public function getDuration() {
        return $this->duration;
    }

    public function getFormattedDuration() {
        return self::minutesToDuration($this->duration);
    }

    public function setDuration($duration) {
        $this->duration = $duration;
    }

    public function getIdMedia() {
        return $this->id_media;
    }

    public function setIdMedia($id_media) {
        $this->id_media = $id_media;
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

    public static function durationToMinutes($duration, $separator = ':'): string
    {
        $durationParts = explode($separator, $duration);
        $hoursInMinutes = intval($durationParts[0]) * 60;
        $minutes = intval($durationParts[1]);
        $durationInMinutes = $hoursInMinutes + $minutes;

        return $durationInMinutes;
    }

    public static function minutesToDuration($minutes, $separator = ':'): string
    {
        $hours = intval($minutes / 60);
        $remainingMinutes = $minutes % 60;
        $durationParts = [$hours, $remainingMinutes];

        return implode($separator, $durationParts);
    }
}
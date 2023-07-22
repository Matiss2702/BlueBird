<?php

namespace App\Requests;

use App\Models\Movie;
use App\Models\MovieCategoryMovie;
use App\Core\FormRequest;
use App\Core\QueryBuilder;

class MovieRequest extends FormRequest
{
    public function __construct()
    {
        parent::__construct($this->rules());
    }

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:2000',
            'release_date' => 'required|date',
            'duration' => 'required|time',
            'ids_category_movie' => 'required',
        ];
    }

    protected function messages(): array
    {   
        return [
            'title.required' => 'Le nom est requis.',
            'title.string' => 'Le nom doit être une chaîne de caractères.',
            'title.max' => 'Le nom ne doit pas dépasser 200 caractères.',
            'description.required' => 'La description est requise.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne doit pas dépasser 2000 caractères.',
            'release_date.required' => 'La date de sortie est requise.',
            'release_date.string' => 'La date de sortie doit être une date.',
            'duration.required' => 'La durée est requise.',
            'ids_category_movie.required' => 'Veuillez sélectionner au moins une catégorie.',
        ];
    }

    public function createMovie(): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        $duration = intval(explode(':', $validatedData['duration'])[0]) * 60 + intval(explode(':', $validatedData['duration'])[1]);

        $movie = new Movie();
        $movie->setTitle($validatedData['title']);
        $movie->setDescription($validatedData['description']);
        $movie->setReleaseDate($validatedData['release_date']);
        $movie->setDuration($duration);
        $movie->setCreatedAt(date("Y-m-d H:i:s")); // TODO : a retirer et mettre CURRENT_TIMESTAMP en BD
        $movie->setUpdatedAt(date("Y-m-d H:i:s")); // TODO : a retirer et mettre CURRENT_TIMESTAMP en BD
        $id_movie = $movie->create();

        $idsCategory = [];
        foreach ($validatedData['ids_category_movie'] as $id_category_movie) {
            $idsCategory[] = [
                'id_movie' => $id_movie,
                'id_category_movie' => $id_category_movie
            ];
        }

        QueryBuilder::table('movie_category_movie')->insertMultiple($idsCategory);

        return true;
    }

    public function updateMovie($movie): bool
    {
        $validatedData = $this->validate();

        if (!$validatedData) {
            return false;
        }

        if (!$movie instanceof Movie) {
            $movie = Movie::find($movie['id']);
        }

        $duration = Movie::durationToMinutes($validatedData['duration']);

        $movie->setTitle($validatedData['title']);
        $movie->setDescription($validatedData['description']);
        $movie->setReleaseDate($validatedData['release_date']);
        $movie->setDuration($duration);
        $movie->setUpdatedAt(date('Y-m-d H:i:s'));
        $movie->update();

        QueryBuilder::table('movie_category_movie')
            ->where('id_movie', '=', $movie->getId())
            ->delete();

        $idsCategory = [];
        foreach ($validatedData['ids_category_movie'] as $id_category_movie) {
            $idsCategory[] = [
                'id_movie' => $movie->getId(),
                'id_category_movie' => $id_category_movie
            ];
        }

        QueryBuilder::table('movie_category_movie')->insertMultiple($idsCategory);

        return true;
    }
}
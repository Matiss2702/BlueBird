<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Controllers\Front\MovieController;
use App\Core\QueryBuilder;
use App\Models\Movie;
use App\Models\CategoryMovie;

class CategoryMovieController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showAction($category_name): void
    {
        $categoryMovie = QueryBuilder::table('category_movie')
            ->select()
            ->where('name', 'ILIKE', '%'. ucfirst(strtolower($category_name)) .'%')
            ->first();
        
        if ($categoryMovie) {
            $movies = QueryBuilder::table('movie')
                ->select(['movie.*', 'media.slug', 'media.alt', 'category_movie.name as category_name'])
                ->join('media', function($join) {
                    $join->on('media.id', '=', 'movie.id_media');
                })
                ->join('movie_category_movie', function ($join) {
                    $join->on('movie.id', '=', 'movie_category_movie.id_movie');
                })
                ->join('category_movie', function ($join) {
                    $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
                })
                ->where('category_movie.id', '=', $categoryMovie['id'])
                ->get();
            $movies = MovieController::groupMovies($movies);
        } else {
            $movies = [];
        }

        view('category-movie/front/show', 'front', [
            'categoryName' => $category_name,
            'categoryMovie' => $categoryMovie,
            'movies' => $movies
        ], [], ['/css/back/movie.css']);
    }
}
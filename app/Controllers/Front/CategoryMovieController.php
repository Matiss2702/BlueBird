<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
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
        $category_name = strtolower($category_name);
        $category_name = ucfirst($category_name);
        $categoryMovie = QueryBuilder::table('category_movie')
            ->select()
            ->where('name', 'LIKE', '%'.$category_name.'%')
            ->first();

        $categoryMovieId = $categoryMovie['id'];

        $movies = QueryBuilder::table('movie')
            ->select([
                'movie.title'
            ])
            ->join('movie_category_movie', function ($join) {
                $join->on('movie.id', '=', 'movie_category_movie.id_movie');
            })
            ->join('category_movie', function ($join) {
                $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
            })
            ->where('category_movie.id', '=', $categoryMovieId)
            ->get();

        view('category-movie/front/show', 'front', [
            'categoryMovie' => $categoryMovie,
            'movies' => $movies
        ]);
    }
}
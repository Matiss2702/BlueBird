<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Movie;
use App\Models\CategoryMovie;
use App\Models\MovieCategoryMovie;
use App\Requests\MovieRequest;

class MovieController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/movie-list.js',
        ];

        $movies = QueryBuilder::table('movie')
            ->select(['movie.*'])
            ->orderBy('movie.title')
            ->get();

        foreach ($movies as &$movie) {
            $movie['duration'] = Movie::minutesToDuration($movie['duration']);
        }

        view('movie/back/list', 'back', [
            'movies' => $movies,
        ], $scripts);
    }

    public function createAction(): void
    {
        $categoriesMovie = CategoryMovie::all();
        $movieCategoriesMovie = MovieCategoryMovie::all();

        view('movie/back/create', 'back', [
            'categoriesMovie' => $categoriesMovie,
            'movieCategoriesMovie' => $movieCategoriesMovie
        ]);
    }

    public function storeAction(): void
    {
        $categoriesMovie = CategoryMovie::all();
        $request = new MovieRequest();;

        if (!$request->createMovie()) {
            view('movie/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
                'categoriesMovie' => $categoriesMovie,
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $movie = Movie::find($id);
        $movieCategoriesMovie = QueryBuilder::table('movie_category_movie')
            ->select()
            ->where('id_movie', $id)
            ->get();

        $movieCategoriesMovie = array_values(array_column($movieCategoriesMovie, 'id_category_movie'));
                
        if (!$movie)
            $this->redirectToList();

        view('movie/back/show', 'back', [
            'movie' => $movie,
            'movieCategoriesMovie' => $movieCategoriesMovie,
            'categoriesMovie' => CategoryMovie::all(), 
        ]);
    }

    public function editAction($id): void
    {
        $movie = Movie::find($id);
        $categoriesMovie = CategoryMovie::all();
        $movieCategoriesMovie = QueryBuilder::table('movie_category_movie')
            ->select()
            ->where('id_movie', $id)
            ->get();
        
        $movieCategoriesMovie = array_values(array_column($movieCategoriesMovie, 'id_category_movie'));

        if (!$movie)
            $this->redirectToList();    

        view('movie/back/edit', 'back', [
            'movie' => $movie,
            'categoriesMovie' => $categoriesMovie,
            'movieCategoriesMovie' => $movieCategoriesMovie
        ]);
    }

    public function updateAction($id): void
    {
        $movie = Movie::find($id);
        $request = new MovieRequest();
        
        if (!$movie) {
            $this->redirectToList();
        }   

        if (!$request->updateMovie($movie)) {
            view('movie/back/edit', 'back', [
                'movie' => $movie,
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld(),
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $movie = Movie::find($id);

        if ($movie) {
            $movie->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/movie/list');
        exit();
    }
}
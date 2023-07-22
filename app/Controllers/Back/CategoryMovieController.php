<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\CategoryMovie;
use App\Requests\CategoryMovieRequest;

class CategoryMovieController extends Controller
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
            '/js/datatables/category-movie-list.js',
        ];
        $categoriesMovie = QueryBuilder::table('category_movie')
            ->select()
            ->orderBy('name')
            ->get();

        view('category-movie/back/list', 'back', [
            'categoriesMovie' => $categoriesMovie,
        ], $scripts);
    }

    public function createAction(): void
    {
        $categoriesMovie = CategoryMovie::all();

        view('category-movie/back/create', 'back', [
            'categoriesMovie' => $categoriesMovie,
        ]);
    }

    public function storeAction(): void
    {
        $categoriesMovie = CategoryMovie::all();
        $request = new CategoryMovieRequest();;

        if (!$request->createCategoryMovie()) {
            view('category-movie/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
                'categoriesMovie' => $categoriesMovie,
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $categoryMovie = CategoryMovie::find($id);
                
        if (!$categoryMovie)
            $this->redirectToList();

        view('category-movie/back/show', 'back', [
            'categoryMovie' => $categoryMovie,
        ]);
    }

    public function editAction($id): void
    {
        $categoryMovie = CategoryMovie::find($id);
       
        if (!$categoryMovie)
            $this->redirectToList();    

        view('category-movie/back/edit', 'back', [
            'categoryMovie' => $categoryMovie,
        ]);
    }

    public function updateAction($id): void
    {
        $categoryMovie = CategoryMovie::find($id);
        $request = new CategoryMovieRequest();
        
        if (!$categoryMovie) {
            $this->redirectToList();
        }   

        if (!$request->updateCategoryMovie($categoryMovie)) {
            view('category-movie/back/edit', 'back', [
                'categoryMovie' => $categoryMovie,
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld(),
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $categoryMovie = CategoryMovie::find($id);

        if ($categoryMovie) {
            $categoryMovie->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/category-movie/list');
        exit();
    }
}
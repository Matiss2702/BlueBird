<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Review;
use App\Models\User;
use App\Models\Movie;
use App\Requests\Back\ReviewRequest;

class ReviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $reviews = QueryBuilder::table('review')
            ->select('review.*', 'user.firstname', 'user.lastname', 'movie.title')
            ->join('user', function($join) {
                $join->on('review.id_user', '=', 'user.id');
            })
            ->join('movie', function($join) {
                $join->on('review.id_movie', '=', 'movie.id');
            })
            ->get();

        view('review/back/list', 'back', [
            'reviews' => $reviews
        ]);
    }

    public function createAction(): void
    {
        $scripts =  [
            '/js/review.js',
        ];

        $stylesheets = [
            '/css/back/review.css',
        ];

        view('review/back/create', 'back', [
            'users' => User::all(),
            'movies' => Movie::all(),
        ], $scripts, $stylesheets);
    }

    public function storeAction(): void
    {
        $scripts =  [
            '/js/review.js',
        ];

        $stylesheets = [
            '/css/back/review.css',
        ];

        $request = new ReviewRequest();

        if (!$request->createReview()) {
            view('review/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld(),
                'users' => User::all(),
                'movies' => Movie::all(),
            ], $scripts, $stylesheets);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $review = QueryBuilder::table('review')
            ->select('review.*', 'user.firstname', 'user.lastname', 'movie.title')
            ->join('user', function($join) {
                $join->on('review.id_user', '=', 'user.id');
            })
            ->join('movie', function($join) {
                $join->on('review.id_movie', '=', 'movie.id');
            })
            ->where('review.id', '=', $id)
            ->first();

        if (!$review)
            $this->redirectToList();

        view('review/back/show', 'back', [
            'review' => $review
        ]);
    }

    public function editAction($id): void
    {
        $scripts =  [
            '/js/review.js',
        ];

        $stylesheets = [
            '/css/back/review.css',
        ];

        $review = QueryBuilder::table('review')
            ->select('review.*', 'user.firstname', 'user.lastname', 'movie.title')
            ->join('user', function($join) {
                $join->on('review.id_user', '=', 'user.id');
            })
            ->join('movie', function($join) {
                $join->on('review.id_movie', '=', 'movie.id');
            })
            ->where('review.id', '=', $id)
            ->first();

        if (!$review)
            $this->redirectToList();

        view('review/back/edit', 'back', [
            'review' => $review,
            'users' => User::all(),
            'movies' => Movie::all(),
        ], $scripts, $stylesheets);
    }

    public function updateAction($id): void
    {
        $review = QueryBuilder::table('review')
            ->select(['review.*', 'review.id as id_review', 'user.firstname', 'user.lastname', 'movie.title'])
            ->join('user', function($join) {
                $join->on('review.id_user', '=', 'user.id');
            })
            ->join('movie', function($join) {
                $join->on('review.id_movie', '=', 'movie.id');
            })
            ->where('review.id', '=', $id)
            ->first();

        if (!$review)
            $this->redirectToList();

        $request = new ReviewRequest();

        if (!$request->updateReview($review)) {
            view('review/back/edit', 'back', [
                'review'   => $review,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $review = Review::find($id);

        if ($review) {
            $review->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/review/list');
        exit();
    }
}
<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Movie;
use App\Models\CategoryMovie;
use App\Models\Comment;
use App\Models\CommentReply;
use DateTime;

class MovieController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //tous les films de base
    // /movie
    public function indexAction(): void
    {
        $movies = QueryBuilder::table('movie')
            ->select(['movie.*', 'media.slug', 'media.alt', 'category_movie.name as category_name'])
            ->join('media', function($join) {
                $join->on('media.id', '=', 'movie.id_media');
            })
            ->join('movie_category_movie', function($join) {
                $join->on('movie_category_movie.id_movie', '=', 'movie.id');
            })
            ->join('category_movie', function($join) {
                $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
            })
            ->orderBy('movie.title', 'asc')
            ->get();

        $categories = QueryBuilder::table('category_movie')
            ->select()
            ->orderBy('category_movie.name', 'asc')
            ->get();

        view('movie/front/index', 'front', [
            'movies' => self::groupMovies($movies),
            'categories' => $categories, 
        ], [], ['/css/back/movie.css']);
    }

    public function queryAction($query) : void 
    {
        if (!$query) redirectHome();

        $movies = QueryBuilder::table('movie')
            ->select(['movie.*', 'media.slug', 'media.alt', 'category_movie.name as category_name'])
            ->join('media', function($join) {
                $join->on('media.id', '=', 'movie.id_media');
            })
            ->join('movie_category_movie', function($join) {
                $join->on('movie_category_movie.id_movie', '=', 'movie.id');
            })
            ->join('category_movie', function($join) {
                $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
            })
            ->orderBy('movie.title', 'asc')
            ->get();
        
        $movies = self::groupMovies($movies);
        
        $categories = QueryBuilder::table('category_movie')
        ->select()
        ->orderBy('category_movie.name', 'asc')
        ->get();

        if (isset($_GET['movie'])) {
            $moviesFiltered = QueryBuilder::table('movie')
                ->select(['movie.*', 'media.slug', 'media.alt', 'category_movie.name as category_name'])
                ->join('media', function($join) {
                    $join->on('media.id', '=', 'movie.id_media');
                })
                ->join('movie_category_movie', function($join) {
                    $join->on('movie_category_movie.id_movie', '=', 'movie.id');
                })
                ->join('category_movie', function($join) {
                    $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
                })
                ->where("movie.title", 'ILIKE', '%'.strtolower($_GET['movie']).'%')
                ->get();

            $moviesFiltered = self::groupMovies($moviesFiltered);
        }

        if (isset($_GET['category'])) {
            $moviesFiltered = QueryBuilder::table('movie')
                ->select(['movie.*', 'media.slug', 'media.alt', 'category_movie.name as category_name'])
                ->join('media', function($join) {
                    $join->on('media.id', '=', 'movie.id_media');
                })
                ->join('movie_category_movie', function($join) {
                    $join->on('movie_category_movie.id_movie', '=', 'movie.id');
                })
                ->join('category_movie', function($join) {
                    $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
                })
                ->where("category_movie.id", '=', $_GET['category'])
                ->get();

            $moviesFiltered = self::groupMovies($moviesFiltered);
        }

        view('movie/front/index', 'front', [
            'movies' => $movies,
            'moviesFiltered' => $moviesFiltered,
            'categories' => $categories,
        ], [], ['/css/back/movie.css']);
    }

    public function showAction($movie_title): void
    {
        $movie_title = ucfirst(strtolower(str_replace(array('%20', '-', '_'), ' ', $movie_title)));

        $movie = QueryBuilder::table('movie')
        ->select(['movie.*', 'media.slug', 'media.alt'])
            ->join('media', function($join) {
                $join->on('media.id', '=', 'movie.id_media');
            })
            ->where('title', 'ILIKE', '%'.$movie_title.'%')
            ->first();

        if (!$movie) redirectHome();

        $movie['duration'] = Movie::minutesToDuration($movie['duration'], 'h');

        $releaseDate = DateTime::createFromFormat('Y-m-d', $movie['release_date']);
        $formattedReleaseDate = $releaseDate->format('d F Y'); // Format complet : jour mois année

        $movieCategoriesMovie = QueryBuilder::table('movie_category_movie')
            ->select()
            ->where('id_movie', $movie['id'])
            ->get();
        $movieCategoriesMovie = array_values(array_column($movieCategoriesMovie, 'id_category_movie'));

        $comments = $this->getCommentsByIdMovie($movie['id']);

        $userId = QueryBuilder::table('user')
            ->select(['id'])
            ->where('email', $_SESSION['user_token'] ?? '')
            ->getColumn('id');

        $title = $movie['title'];
        $title = 'BlueBird - '. $title;

        $description = $movie['description'];
        $description = 'Review du film : ' . $title . ' par BlueBird. ' . $description;

        view('movie/front/show', 'front', [
            'movie' => $movie,
            'movie_title' => $movie_title,
            'movieCategoriesMovie' => $movieCategoriesMovie,
            'categoriesMovie' => CategoryMovie::all(),
            'isConnected' => isConnected(),
            'idUser' => $userId,
            'comments' => $comments,
            'movie_duration' => $movie['duration'],
            'release_date' => $formattedReleaseDate,
            'title' => $title,
            'description' => $description,
        ], [], ['/css/back/movie.css']);
    }

    private function getCommentsByIdMovie($idMovie): array
    {
        $commentRows = QueryBuilder::table('comment')
            ->select([
                'comment.id AS id_comment',
                'comment.id_status AS id_comment_status',
                'comment.*',
                'comment_reply.id AS id_reply',
                'comment_reply.id_status AS id_reply_status',
                'comment_reply.content AS reply_content',
                'comment_reply.created_at AS reply_date',
                'user_comment.firstname AS firstname_comment',
                'user_comment.lastname AS lastname_comment',
                'user_reply.firstname AS firstname_reply',
                'user_reply.lastname AS lastname_reply'
            ], ['user_comment', 'user_reply'])
            ->join('user', function ($join) {
                $join->on('user_comment.id', '=', 'comment.id_user');
            }, 'user_comment')
            ->leftJoin('comment_reply', function ($join) {
                $join->on('comment_reply.id_comment', '=', 'comment.id');
                $join->on('comment_reply.id_status', '=', ID_COMMENT_STATUS_ACTIF, false);
            })
            ->leftJoin('user', function ($join) {
                $join->on('user_reply.id', '=', 'comment_reply.id_user');
            }, 'user_reply')
            ->where('entity', 'movie')
            ->andWhere('id_entity', $idMovie)
            ->andWhere('comment.id_status', 1)
            ->orderBy('comment.created_at', 'DESC')
            ->orderBy('comment_reply.created_at')
            ->get();

        $comments = [];

        foreach ($commentRows as $row) {
            $commentId = $row['id_comment'];

            // commentaire
            if (!isset($comments[$commentId])) {
                $comment = new Comment();
                $comment->setId($row['id_comment']);
                $comment->setContent($row['content']);
                $comment->setIdStatus($row['id_comment_status']);
                $comment->setCreatedAt($row['created_at']);
                $comment->setUsername($row['firstname_comment'] . ' ' . $row['lastname_comment']);

                $comments[$commentId] = $comment;
            }

            // éventuelles réponses au commentaire
            if ($row['id_reply']) {
                $reply = new CommentReply();
                $reply->setId($row['id_reply']);
                $reply->setContent($row['reply_content']);
                $reply->setIdStatus($row['id_reply_status']);
                $reply->setCreatedAt($row['reply_date']);
                $reply->setUsername($row['firstname_reply'] . ' ' . $row['lastname_reply']);

                $comments[$commentId]->addReply($reply);
            }
        }

        return $comments;
    }

    public static function groupMovies($movies): array
    {
        $groupedMovies = [];
        foreach ($movies as $movie) {
            $movieId = $movie['id'];
            $category = $movie['category_name'];
        
            if (isset($groupedMovies[$movieId])) {
                $groupedMovies[$movieId]['categories'][] = $category;
            } else {
                $groupedMovies[$movieId] = $movie;
                $groupedMovies[$movieId]['categories'] = [$category];
            }

            unset($groupedMovies[$movieId]['category_name']);
        }

        return $groupedMovies;
    }

    private function redirectToList(): void
    {
        header('Location: /movie');
        exit();
    }
}

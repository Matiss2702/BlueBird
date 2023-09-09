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
        $movies = Movie::all();

        $categoriesMovie = QueryBuilder::table('category_movie')
            ->select()
            ->orderBy('category_movie.name', 'asc')
            ->get();

        // $CategoriesMovie = QueryBuilder::table('category_movie')
        //     ->select(
        //         [
        //             'category_movie.name',
        //             'COUNT(movie_category_movie.id_category_movie) AS appearance'
        //         ]
        //     )
        //     ->leftJoin('movie_category_movie', function($join) {
        //         $join->on('category_movie.id', '=', 'movie_category_movie.id_category_movie'); 
        //     })
        //     ->groupBy('category_movie.name')
        //     ->orderBy('category_movie.name', 'asc')
        //     ->get();

        view('movie/front/index', 'front', [
            'movies' => $movies,
            'categoriesMovie' => $categoriesMovie, 
        ]);
    }

    public function queryAction($query) : void 
    {
        $params = $_GET;

        $movies = Movie::all();
        
        $categoriesMovie = QueryBuilder::table('category_movie')
        ->select()
        ->orderBy('category_movie.name', 'asc')
        ->get();

        if (isset($params['category_movie'])) {
            $categoryMovie = $_GET['category_movie'];
            $categoryMovie = ucfirst(strtolower($categoryMovie));

            $categoriesMovieFiltered = QueryBuilder::table('movie')
                ->select([
                    'movie.title'
                ])
                ->join('movie_category_movie', function($join) {
                    $join->on('movie.id', '=', 'movie_category_movie.id_movie');
                })
                ->join('category_movie', function($join) {
                    $join->on('movie_category_movie.id_category_movie', '=', 'category_movie.id');
                })
                ->where('category_movie.name', 'ILIKE', '%'.$categoryMovie.'%')
                ->get();
        } 
        
        if (isset($_GET['movie_name'])) {
            $movie = $_GET['movie_name'];
            $movie = strtolower($movie);

            $moviesFiltered = QueryBuilder::table('movie')
            ->select()
            ->where("movie.title", 'ILIKE', '%'.$movie.'%')
            ->get();        
        }

        if (!$query)
            redirectHome();

        view('movie/front/index', 'front', [
            'movies' => $movies,
            'moviesFiltered' => $moviesFiltered,
            'categoriesMovie' => $categoriesMovie, 
            'categoriesMovieFilted' => $categoriesMovieFiltered, 
        ]);
    }


    //la page d'un film 
    // /movie/fast-and-furious-8 par exemple
    public function showAction($movie_title): void
    {
        $movie_title = str_replace(array('%20', '-', '_'), ' ', $movie_title);
        $movie_title = strtolower($movie_title);
        $movie_title = ucfirst($movie_title);

        $movie = QueryBuilder::table('movie')
            ->select()
            ->where('title', 'LIKE', '%'.$movie_title.'%')
            ->first();

        $movie_id = $movie['id'];

        if (!$movie)
            redirectHome();

        $movie_duration = $movie['duration'];
        $heures = floor($movie_duration / 60);
        $minutes = $movie_duration % 60;
        $movie_duration = sprintf('%02d:%02d', $heures, $minutes);

        $release_date = $movie['release_date'];
        $date = new DateTime($release_date);

        $mois_en_francais = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
        ];
        
        $jour = $date->format('d');
        $mois = $mois_en_francais[intval($date->format('m'))];
        $annee = $date->format('Y');
        
        $release_date = $jour . ' ' . $mois . ' ' . $annee;


        $movieCategoriesMovie = QueryBuilder::table('movie_category_movie')
            ->select()
            ->where('id_movie', $movie_id)
            ->get();
        $movieCategoriesMovie = array_values(array_column($movieCategoriesMovie, 'id_category_movie'));

        $comments = $this->getCommentsByIdMovie($movie_id);

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
            'movieCategoriesMovie' => $movieCategoriesMovie,
            'categoriesMovie' => CategoryMovie::all(),
            'isConnected' => isConnected(),
            'idUser' => $userId,
            'comments' => $comments,
            'movie_duration' => $movie_duration,
            'release_date' => $release_date,
            'title' => $title,
            'description' => $description,
        ]);
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

    private function redirectToList(): void
    {
        header('Location: /movie');
        exit();
    }
}

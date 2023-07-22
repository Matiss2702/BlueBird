<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Movie;
use App\Models\CategoryMovie;
use App\Models\Comment;
use App\Models\CommentReply;

class MovieController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function showAction($id): void
    {
        $movie = Movie::find($id);
        if (!$movie)
            redirectHome();

        $movieCategoriesMovie = QueryBuilder::table('movie_category_movie')
            ->select()
            ->where('id_movie', $id)
            ->get();
        $movieCategoriesMovie = array_values(array_column($movieCategoriesMovie, 'id_category_movie'));

        $comments = $this->getCommentsByIdMovie($id);

        $userId = QueryBuilder::table('user')
            ->select(['id'])
            ->where('email', $_SESSION['login'] ?? '')
            ->getColumn('id');

        view('movie/front/show', 'front', [
            'movie' => $movie,
            'movieCategoriesMovie' => $movieCategoriesMovie,
            'categoriesMovie' => CategoryMovie::all(),
            'isConnected' => isConnected(),
            'idUser' => $userId,
            'comments' => $comments
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
}
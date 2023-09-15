<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Comment;
use App\Models\CommentStatus;
use App\Requests\Back\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $comments = QueryBuilder::table('comment')
            ->select([
                'comment.*',
                'user.firstname',
                'user.lastname',
                'comment_status.intitule AS comment_status'
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment.id_user');
            })
            ->join('comment_status', function($join) {
                $join->on('comment.id_status', '=', 'comment_status.id');
            })
            ->orderBy('comment.created_at')
            ->get();

        view('comment/back/list', 'back', [
            'comments' => $comments
        ]);
    }

    public function showAction($id): void
    {
        $comment = QueryBuilder::table('comment')
            ->select([
                'comment.*',
                'user.firstname',
                'user.lastname',
                'comment_status.intitule AS comment_status'
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment.id_user');
            })
            ->join('comment_status', function($join) {
                $join->on('comment.id_status', '=', 'comment_status.id');
            })
            ->where('comment.id', $id)
            ->first();

        if (!$comment)
            $this->redirectToList();

        view('comment/back/show', 'back', [
            'comment' => $comment
        ]);
    }

    public function editAction($id): void
    {
        $comment = QueryBuilder::table('comment')
            ->select([
                'comment.*',
                'user.firstname',
                'user.lastname' 
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment.id_user');
            })
            ->where('comment.id', $id)
            ->first();

        if (!$comment)
            $this->redirectToList();

        view('comment/back/edit', 'back', [
            'comment'       => $comment,
            'commentStatus' => CommentStatus::all()
        ]);
    }

    public function updateAction($id): void
    {
        $request = new CommentRequest();
        $comment = Comment::find($id);

        if (!$request->updateComment($comment)) {
            $comment = QueryBuilder::table('comment')
            ->select([
                'comment.*',
                'user.firstname',
                'user.lastname'
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment.id_user');
            })
            ->where('comment.id', $id)
            ->first();

            view('comment/back/edit', 'back', [
                'comment' => $comment,
                'errors'  => $request->getErrors(),
                'old'     => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $comment = Comment::find($id);

        if ($comment) {
            $comment->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/comment/list');
        exit();
    }
}
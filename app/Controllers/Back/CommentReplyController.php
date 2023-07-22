<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\CommentStatus;
use App\Requests\Back\CommentReplyRequest;

class CommentReplyController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $comments = QueryBuilder::table('comment_reply')
            ->select([
                'comment_reply.*',
                'user.firstname',
                'user.lastname',
                'comment_status.intitule AS comment_status'
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment_reply.id_user');
            })
            ->join('comment_status', function($join) {
                $join->on('comment_reply.id_status', '=', 'comment_status.id');
            })
            ->orderBy('comment_reply.created_at')
            ->get();

        view('comment-reply/back/list', 'back', [
            'comments' => $comments
        ]);
    }

    public function showAction($id): void
    {
        $comment = QueryBuilder::table('comment_reply')
            ->select([
                'comment_reply.id AS comment_id',
                'comment_reply.content AS comment_content',
                'comment_reply.created_at AS comment_date',
                'comment.id AS parent_id',
                'comment.content AS parent_content',
                'comment.created_at AS parent_date',
                'user_comment.firstname AS comment_firstname',
                'user_comment.lastname AS  comment_lastname',
                'user_parent.firstname AS parent_firstname',
                'user_parent.lastname AS  parent_lastname',
                'cs_comment.intitule AS comment_status',
                'cs_parent.intitule AS parent_status',
            ], ['user_comment', 'user_parent'])
            ->join('user', function($join) {
                $join->on('user_comment.id', '=', 'comment_reply.id_user');
            }, 'user_comment')
            ->join('comment', function($join) {
                $join->on('comment.id', '=', 'comment_reply.id_comment');
            })
            ->join('user', function($join) {
                $join->on('user_parent.id', '=', 'comment.id_user');
            }, 'user_parent')
            ->join('comment_status', function($join) {
                $join->on('cs_parent.id', '=', 'comment.id_status');
            }, 'cs_parent')
            ->join('comment_status', function($join) {
                $join->on('cs_comment.id', '=', 'comment_reply.id_status');
            }, 'cs_comment')
            ->where('comment_reply.id', $id)
            ->first();

        if (!$comment)
            $this->redirectToList();

        view('comment-reply/back/show', 'back', [
            'comment' => $comment,
            'parentComment' => Comment::find($id)
        ]);
    }

    public function editAction($id): void
    {
        $comment = QueryBuilder::table('comment_reply')
            ->select([
                'comment_reply.*',
                'user.firstname',
                'user.lastname'
            ])
            ->join('user', function($join) {
                $join->on('user.id', '=', 'comment_reply.id_user');
            })
            ->where('comment_reply.id', $id)
            ->first();

        if (!$comment)
            $this->redirectToList();

        view('comment-reply/back/edit', 'back', [
            'comment' => $comment,
            'commentStatus' => CommentStatus::all()
        ]);
    }

    public function updateAction($id): void
    {
        $movie = CommentReply::find($id);

        if (!$movie) {
            $this->redirectToList();
        }   

        $request = new CommentReplyRequest();

        if (!$request->updateCommentReply($movie)) {
            $comment = QueryBuilder::table('comment_reply')
                ->select([
                    'comment_reply.*',
                    'user.firstname',
                    'user.lastname'
                ])
                ->join('user', function($join) {
                    $join->on('user.id', '=', 'comment_reply.id_user');
                })
                ->where('comment_reply.id', $id)
                ->first();
    
            view('comment-reply/back/edit', 'back', [
                'comment' => $comment,
                'commentStatus' => CommentStatus::all(),
                'errors'    => $request->getErrors(),
                'old'       => $request->getOld(),
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $comment = CommentReply::find($id);

        if ($comment) {
            $comment->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/comment-reply/list');
        exit();
    }
}
<?php

namespace App\Controllers;

use App\Models\Post;
use App\Requests\PostRequest;

class PostController extends Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/post-list.js',
        ];
        
        view('post/back/list', 'back', [
            'posts' => Post::all()
        ], $scripts);
    }

    public function createAction(): void
    {
        view('post/back/create', 'back');
    }

    public function storeAction(): void
    {
        $request = new PostRequest();

        if (!$request->createPost()) {
            view('post/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $post = Post::find($id);

        if (!$post)
            $this->redirectToList();

        view('post/back/show', 'back', [
            'post' => $post
        ]);
    }

    public function editAction($id): void
    {
        $post = Post::find($id);

        if (!$post)
            $this->redirectToList();

        view('post/back/edit', 'back', [
            'post' => $post
        ]);
    }

    public function updateAction($id): void
    {
        $post = Post::find($id);

        if (!$post) {
            $this->redirectToList();
        }

        $request = new PostRequest();

        if (!$request->updatePost($post)) {
            view('post/back/edit', 'back', [
                'post'   => $post,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $post = Post::find($id);

        if ($post) {
            $post->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/post/list');
        exit();
    }
}
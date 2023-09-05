<?php

namespace App\Controllers;

use App\Core\QueryBuilder;
use App\Models\Page;
use App\Requests\PageRequest;

class PageController extends Controller{

    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        $scripts = [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/page-list.js',
        ];

        view('page/back/list', 'back', [
            'pages' => Page::all()
        ], $scripts);
    }

    public function createAction(): void
    {
        $scripts = [
            '/js/tinymce/editor.js',
        ];

        view('page/back/create', 'back', [], $scripts);
    }

    public function storeAction(): void
    {
        $request = new PageRequest();
        
        $scripts = [
            '/js/tinymce/editor.js',
        ];

        if (!$request->createPage()) {
            view('page/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ], $scripts);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $page = Page::find($id);

        $scripts = [
            '/js/tinymce/editor.js',
            '/js/page/create.js',
        ];

        if (!$page)
            $this->redirectToList();

        view('page/back/show', 'back', [
            'page' => $page
        ], $scripts);
    }

    public function editAction($id): void
    {
        $page = Page::find($id);

        $scripts = [
            '/js/tinymce/editor.js',
        ];

        if (!$page)
            $this->redirectToList();

        view('page/back/edit', 'back', [
            'page' => $page
        ], $scripts);
    }

    public function updateAction($id): void
    {
        $scripts = [
            '/js/tinymce/editor.js',
        ];

        $page = Page::find($id);

        if (!$page) {
            $this->redirectToList();
        }

        $request = new PageRequest();

        if (!$request->updatePage($page)) {
            view('page/back/edit', 'back', [
                'page'   => $page,
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ], $scripts);
        }

        $this->redirectToList();
    }

    public function deleteAction($id): void
    {
        $page = Page::find($id);

        if ($page) {
            $page->delete();
        }

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/page/list');
        exit();
    }
}
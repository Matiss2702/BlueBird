<?php

namespace App\Controllers\Back;

use App\Controllers\Controller;
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
        $scripts =  [
            '/js/datatables/datatables.min.js',
            '/js/datatables/index.js',
            '/js/datatables/page-list.js',
        ];

        $pages = Page::all();

        view('page/back/list', 'back', [
            'pages' => $pages
        ],$scripts);
    }

    public function createAction(): void
    {
        $scripts =  [
            '/js/tinymce/selector.js'
        ];

        view('page/back/create', 'back', [], $scripts);
    }

    public function storeAction(): void
    {
        $request = new PageRequest();

        if (!$request->createPage()) {
            view('page/back/create', 'back', [
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }

        $this->redirectToList();
    }

    public function showAction($id): void
    {
        $page = Page::find($id);

        if (!$page)
            $this->redirectToList();

        view('page/back/show', 'back', [
            'page' => $page
        ]);
    }

    public function editAction($id): void
    {
        $scripts =  [
            '/js/tinymce/selector.js'
        ];

        $page = Page::find($id);

        if (!$page)
            $this->redirectToList();

        view('page/back/edit', 'back', [
            'page' => $page
        ], $scripts);
    }

    public function updateAction($id): void
    {
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
            ]);
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
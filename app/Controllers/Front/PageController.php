<?php

namespace App\Controllers\Front;

use App\Controllers\Controller;
use App\Models\Page;
use App\Requests\PageRequest;

class PageController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction($id): void
    {
        $page = Page::find($id);

        if (!$page) {
            redirectHome();
        }

        view('page/front/index', 'front', [
                'page' => $page
            ]
        );
    }
}

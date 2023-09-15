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

    public function pageAction($slug): void
    {
        $title = WEBSITE_TITLE;
        $description = WEBSITE_DESCRIPTION;

        $slug = '/'.$slug;
        
        $page = Page::where("slug", $slug);

        if (!$page) {
            view('Error/not-found', 'front', [
                'status' => '404',
                'title' => $title . ' - Page non trouvéee', 
            ]);
        }

        $title = WEBSITE_TITLE .' - '. $page->getTitle();
        $description = $page->getDescription();

        view('page/front/page', 'front', [
            'page' => $page,
            'title' => $title,
            'description' => $description
        ]);
    }

    public function indexAction(): void
    {
        $title = WEBSITE_TITLE;
        $description = WEBSITE_DESCRIPTION;

        $slug = '/';
        $page = Page::where("slug", $slug);

        $title = WEBSITE_TITLE .' - '. $page->getTitle();
        $description = $page->getDescription();

        view('page/front/index', 'front', [
            'title' => $title,
            'page' => $page,
            'description' => $description
        ]);
    }
}
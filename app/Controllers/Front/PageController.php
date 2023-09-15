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

    public function indexAction($slug): void
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
        
        $stylesheets = [
            '/vendor/bootstrap/all.css',
        ];

        $scripts = [];

        view('page/front/index', 'front', [
                'page' => $page,
                'title' => $title,
                'description' => $description
        ], $scripts, $stylesheets
        );
    }
}
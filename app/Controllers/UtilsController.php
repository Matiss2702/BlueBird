<?php

namespace App\Controllers;

use App\Models\Page;
use App\Models\Post;

class UtilsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listAction(): void
    {
        view('utils/back/list', 'back');
    }

    public function generateSitemapAction(): void
    {
        $staticPages = [
            'contact',
            'profile',
            'settings'
        ];

        $pages = Page::all();
        $pagesSlugs = array_column($pages, 'slug');
        $posts = Post::all();
        $postsSlugs = array_column($posts, 'slug');

        $locs = array_merge($staticPages, $pagesSlugs, $postsSlugs);

        $websiteUrl = $_SERVER['HTTP_HOST'];
        $rootPath = $_SERVER['DOCUMENT_ROOT'];
        $sitemapPath = $rootPath . '/sitemap.xml';

        $xmlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xmlContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $xmlContent .= '<url>' . "\n";

        foreach ($locs as $loc) {
            $xmlContent .= '<loc>' . $websiteUrl . '/' . $loc . '</loc>' . "\n";
        }

        $xmlContent .= '</url>' . "\n";

        $xmlContent .= '</urlset>' . "\n";

        file_put_contents($sitemapPath, $xmlContent);

        $this->redirectToList();
    }

    private function redirectToList(): void
    {
        header('Location: /admin/utils/list');
        exit();
    }
}

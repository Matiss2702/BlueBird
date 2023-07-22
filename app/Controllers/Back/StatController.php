<?php

namespace App\Controllers\Back;
use App\Controllers\Controller;
use App\Core\QueryBuilder;
use App\Models\User;
use App\Models\Message;
use App\Models\Productor;
use App\Models\Movie;
use App\Models\Post;


class StatController extends Controller
{

    public function dashboardAction()
    {
        $scripts =  [
            // '/js/stat.js/chart-stat-user.js',
            '/vendor/chart.js/demo/chart-area-demo.js',
            '/vendor/chart.js/demo/chart-pie-demo.js'
        ];
        $messages = QueryBuilder::table('message')
        ->select(
            'message.*',
            'categorie_message.description'
        )
        ->join('categorie_message', function($join) {
            $join->on('message.id_categorie_message', '=', 'categorie_message.id');
        })
        ->get();

        $users = User::all();
        $post = Post::all();
        $movie = Movie::all();

        view('Stat/dashboard', 'back', [
            'title' => 'Dashboard',
            'isConnected' => isConnected(),
            'User' => $users,
            'Post' => $post,
            'Message' => $messages,
            'Movie' => $movie,
        ], $scripts);
    }

}
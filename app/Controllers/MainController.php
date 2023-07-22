<?php
namespace App\Controllers;

class MainController extends Controller{

    public function homeAction() {
        view('Main/home', 'front', [
            'isConnected' => isConnected()
        ]);
    }

}
<?php

namespace App\Controllers;

use App\Requests\LoginRequest;
use App\Requests\RegisterRequest;

class AuthController extends Controller{
 
    public function __construct()
    {
        parent::__construct();
    }

    public function loginAction(): void
    {
        if (isConnected())
            redirectHome();

        view('auth/front/login', 'front', [
            'title' => 'Blue Bird | Connexion'
        ]);
    }

    public function loginProcessAction()
    {
        $post = $this->getRequest()->getPost();

        if (!$post)
            redirectHome();

        $request = new LoginRequest();

        if (!$request->authenticate()) {
            view('auth/front/login', 'front', [
                'title' => 'Blue Bird | Connexion',
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }
    }

    public function registerAction(): void
    {
        if (isConnected())
            redirectHome();

        view('auth/front/register', 'front', [
            'title' => 'Blue Bird | Inscription'
        ]);
    }

    public function registerProcessAction()
    {
        $post = $this->getRequest()->getPost();

        if (!$post)
            redirectHome();

        $request = new RegisterRequest();

        if (!$request->createUser()) {
            view('auth/front/register', 'front', [
                'title' => 'Blue Bird | Connexion',
                'errors' => $request->getErrors(),
                'old'    => $request->getOld()
            ]);
        }
    }

    public function logoutAction(): void
    {
        session_destroy();
        redirectHome();
    }

}
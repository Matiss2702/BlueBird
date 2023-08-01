<?php

namespace App\Controllers;

use App\Models\User;

class MainController extends Controller
{
    public function homeAction()
    {
        session_start();

        $isConnected = isConnected();
        $user = null;

        if ($isConnected) {
            $email = $_SESSION['login'];

            $user = User::where("email", $email);
        }

        view('Main/home', 'front', [
            'isConnected' => $isConnected,
            'user' => ($user !== null) ? $user->getFirstname() : null
        ]);
    }
}

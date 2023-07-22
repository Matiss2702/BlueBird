<?php

namespace App\Middlewares;

use App\Core\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle()
    {
        if (!$this->isUserAuthenticated()) {
            header('Location: /login');
            exit();
        }
    }

    private function isUserAuthenticated(): bool
    {
        return isset($_SESSION['login']);
    }
}

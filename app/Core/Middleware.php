<?php

namespace App\Core;

use App\Core\Model;

abstract class Middleware extends Model
{

    protected function getTokenLogin()
    {
        return $_SESSION['user_token'];
    }

    protected function generateToken()
    {
        return md5(uniqid(rand(), true));
    }

    protected function associateTokenWithUser($userId)
    {
        $token = $this->generateToken();
        $_SESSION['user_token'] = $token;
    }
}

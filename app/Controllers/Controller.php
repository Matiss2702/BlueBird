<?php

namespace App\Controllers;

use App\Core\Request;

class Controller
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected function getRequest()
    {
        return $this->request;
    }

    protected function redirectHome() : void
    {
        header("Location: /");
        exit();
    }

}

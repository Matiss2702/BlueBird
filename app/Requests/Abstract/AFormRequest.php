<?php

namespace App\Requests\Abstract;

use App\Core\Request;

abstract class AFormRequest
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    abstract protected function validate();

    protected function getRequest()
    {
        return $this->request;
    }
}
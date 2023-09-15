<?php

namespace App\Core;

class Request
{
    private $postData;

    public function __construct()
    {
        $this->postData = $_POST;
        $this->postData = new \ArrayObject($_POST, \ArrayObject::ARRAY_AS_PROPS);
    }

    public function getPost($key = null)
    {
        if ($key !== null) {
            return isset($this->postData[$key]) ? $this->postData[$key] : null;
        }

        return $this->postData;
    }

}

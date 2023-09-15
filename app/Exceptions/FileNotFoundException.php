<?php

namespace App\Exceptions;

class FileNotFoundException extends \Exception {
    protected $message = "Le fichier spécifié n'existe pas.";
    protected $code = HTTP_INTERNAL_SERVER_ERROR;

    public function __construct() {
        parent::__construct($this->message, $this->code);
    }
}

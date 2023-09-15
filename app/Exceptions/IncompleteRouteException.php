<?php

namespace App\Exceptions;

class IncompleteRouteException extends \Exception {
    protected $message = "La route spécifiée n'est pas complète.";
    protected $code = HTTP_INTERNAL_SERVER_ERROR;

    public function __construct() {
        parent::__construct($this->message, $this->code);
    }
}

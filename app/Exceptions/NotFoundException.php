<?php

namespace App\Exceptions;

class NotFoundException extends \Exception {
    protected $message = "La page demandée n'a pas été trouvée.";
    protected $code = HTTP_NOT_FOUND;

    public function __construct() {
        parent::__construct($this->message, $this->code);
    }
}

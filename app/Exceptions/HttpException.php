<?php

namespace App\Exceptions;

class HttpException extends \Exception {
    protected $message = "Une erreur est survenue.";
    protected $code = HTTP_INTERNAL_SERVER_ERROR;

    public function __construct($message = '', $code = '') {
        if (!$message) {
            $message = $this->message;
        }

        if (!$code) {
            $code = $this->code;
        }

        parent::__construct($message, $code);
    }
}

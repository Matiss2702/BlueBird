<?php

namespace App\Exceptions;

class DatabaseException extends \Exception {
    protected $message = "Une erreur de base de données est survenue.";
    protected $code = HTTP_INTERNAL_SERVER_ERROR;

    public function __construct($message = null, $code = null, \Throwable $previous = null) {
        if (!$message) {
            $message = $this->message;
        }

        if (!$code) {
            $code = $this->code;
        }

        if (!APP_DEBUG) {
            $message = $this->message; // en mode production, ne montrer que le message générique
        }

        parent::__construct($message, $code, $previous);
    }
}

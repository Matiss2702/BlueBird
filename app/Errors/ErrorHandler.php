<?php
namespace App\Errors;

use App\Core\View;
use App\Exceptions\DatabaseException;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\HttpException;
use App\Exceptions\IncompleteRouteException;

class ErrorHandler
{
    public static function handle($exception)
    {
        if (APP_DEBUG) {
            echo '<pre>';
            throw $exception; // En preprod, on affiche toutes les erreurs.
        }

        $param = [];
        $viewPath = 'Error/internal-server-error';
        switch (true) {
            case $exception instanceof DatabaseException:
                http_response_code($exception->getCode());
                $params['title'] = 'Erreur interne du serveur';
                break;
            case $exception instanceof FileNotFoundException:
                http_response_code($exception->getCode());
                $params['title'] = $exception->getMessage();
                break;
            case $exception instanceof IncompleteRouteException:
                http_response_code($exception->getCode());
                $params['title'] = $exception->getMessage();
                break;
            case $exception instanceof HttpException:
                http_response_code($exception->getCode());
                if ($exception->getCode() == HTTP_NOT_FOUND)
                    $viewPath = 'Error/not-found';
                $params['title'] = $exception->getMessage();
                break;
            default:
                http_response_code(HTTP_INTERNAL_SERVER_ERROR);
                $params['title'] = 'Erreur interne du serveur';
                break;
        }

        $view = new View($viewPath, 'front');

        foreach ($params as $name => $param) {
            $view->assign($name, $param);
        }

        $view->render();
    }

}

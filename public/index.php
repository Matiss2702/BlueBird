<?php

namespace App;

/*
if (file_exists(__DIR__ . '/setup/index.html') && strpos($_SERVER['REQUEST_URI'], '/api/') !== 0) {
    header('Location: /setup/index.html');
    exit;
}
*/

use App\Core\Router;
use App\Errors\ErrorHandler;

require __DIR__ . '/../app/Helpers/functions.php';
require __DIR__ . '/../config/config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

spl_autoload_register(function ($class) {
    $file = str_replace(["App\\", "\\"], ["", "/"], $class);
    $file = __DIR__ . '/../app/' . $file.".php";

    if (file_exists($file)) {
        include $file;
    }
});
    
set_exception_handler([ErrorHandler::class, 'handle']);

try {
    $uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
    $uri = htmlspecialchars($uri, ENT_QUOTES, 'UTF-8');

    $router = Router::getInstance();

    require __DIR__ . '/../app/Routes/web.php';
    require __DIR__ . '/../app/Routes/api.php';

    $router->resolve();

} catch (\Exception $e) {
    ErrorHandler::handle($e);
}
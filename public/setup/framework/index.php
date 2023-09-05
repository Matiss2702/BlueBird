<?php

echo "<!-- coucou -->";
$route = strtok($_SERVER['REQUEST_URI'], '?');

if(str_starts_with($route, '/articles')) {
    $basePath = "/articles";
    require('./articles.php');
} else {
    echo "Hello World!";
}

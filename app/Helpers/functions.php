<?php

function view(string $view, string $template, array $data = [], array $scripts = [], array $stylesheets = []): void
{
    $viewInstance = new App\Core\View($view, $template);
    if ($template === 'front' || $template === 'account') {
        $viewInstance->assign('menus', App\Models\Menu::all());
    }
    foreach ($data as $key => $value) {
        $viewInstance->assign($key, $value);
    }
    foreach ($scripts as $script) {
        $viewInstance->addScript($script);
    }
    foreach ($stylesheets as $stylesheet) {
        $viewInstance->addStylesheet($stylesheet);
    }
    $viewInstance->render();
}

function isConnected(): bool
{
    return isset($_SESSION['user_token']);
}

function onProd(): bool
{
    return false;
}

function getBaseUrl(): string
{
    if (onProd()) {
        return 'http://154.56.57.33:8081/';
    } else {
        return 'http://localhost:8081';
    }
}

function redirectHome(): void
{
    header('Location: /');
    exit();
}

function cameltoSnakeCase($str): string
{
    return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $str));
}

function snakeToCamelCase($str): string
{
    return str_replace('_', '', ucwords($str, '_'));
}

<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use App\Router\RouterMapper;
use App\Controller\HomeController;
use App\Router\Exception\RouterException;

$router = new RouterMapper();

$router->get('/',[HomeController::class, 'home']);
$router->get('/about',[HomeController::class, 'about']);

try {
    $router->handleRoute($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (RouterException $e) {
    echo 'Error' . $e->getMessage();
}
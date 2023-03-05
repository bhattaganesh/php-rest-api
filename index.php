<?php

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers.php';

use Ganesh\PhpRestApi\App;
use Ganesh\PhpRestApi\Controllers\UserController;


$app = new App();

$app->router->get('users/', [UserController::class, 'getAll']);
$app->router->get('users/:id', [UserController::class, 'getById']);
$app->router->post('users/', [UserController::class, 'create']);
$app->router->put('users/:id', [UserController::class, 'update']);
$app->router->delete('users/:id', [UserController::class, 'delete']);

$app->run();


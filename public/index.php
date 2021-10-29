<?php

use Clientes\Clientes;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes user
require __DIR__ . '/Controller/UserController.php';

$app->post('/', \UserController::class . ":salvar");

$app->get('/',\UserController::class . ":usuarios");

$app->get('/{id}',\UserController::class . ":pesquisar");

$app->delete('/{id}',\UserController::class . ":deletar");

// Run app
$app->run();

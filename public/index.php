<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/posts/{id:\d}', function (Request $request) {
});

$app->post('/posts/{id:\d}', function (Request $request) {
});

$app->put('/posts/{id:\d}', function (Request $request) {
});

$app->run();
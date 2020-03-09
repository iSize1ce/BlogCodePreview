<?php declare(strict_types=1);

use Http\Handler\CreatePostHandler;
use Http\Handler\GetPostHandler;
use Http\Handler\GetPostsHandler;
use Http\Handler\UpdatePostHandler;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require_once __DIR__ . '/../vendor/autoload.php';

(static function () {
    $app = AppFactory::create();

    // @todo add DI container

    $app->group('/posts', static function (RouteCollectorProxy $postApp) {
        $postApp->get('/', GetPostsHandler::class);
        $postApp->post('/', CreatePostHandler::class);

        $postApp->group('/posts/{id:\d}', static function (RouteCollectorProxy $postByIdApp) {
            $postByIdApp->get('/', GetPostHandler::class);
            $postByIdApp->put('/', UpdatePostHandler::class);
        });
    });

    $app->run();
})();

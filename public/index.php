<?php declare(strict_types=1);

use Post\PostFacade;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\JsonResponse;
use Slim\Psr7\Request;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/posts/{id:\d}', static function (Request $request, PostFacade $postFacade) {
    $id = (int)$request->getAttribute('id');
    if ($id <= 0) {
        throw new HttpBadRequestException($request);
    }

    $post = $postFacade->getById($id);
    if ($post === null) {
        throw new HttpNotFoundException($request);
    }

    return new JsonResponse([
        'id' => $post->getId(),
        'title' => $post->getTitle(),
        'content' => $post->getContent()
    ]);
});

$app->post('/posts', static function (Request $request, PostFacade $postFacade) {
});

$app->put('/posts/{id:\d}', static function (Request $request, PostFacade $postFacade) {
    $id = (int)$request->getAttribute('id');
    if ($id <= 0) {
        throw new HttpBadRequestException($request);
    }

    $post = $postFacade->getById($id);
    if ($post === null) {
        throw new HttpNotFoundException($request);
    }

    $body = $request->getParsedBody();

    if (array_key_exists('title', $body)) {
        $post->setTitle($body['title']);
    }
    if (array_key_exists('text', $body)) {
        $post->setContent($body['text']);
    }

    $postFacade->update($post);

    return new JsonResponse([
        'id' => $post->getId(),
        'title' => $post->getTitle(),
        'text' => $post->getContent()
    ]);
});

$app->run();
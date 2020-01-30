<?php declare(strict_types=1);

namespace Http\Handler;

use Http\Slim\JsonResponse;
use Post\PostFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GetPostHandler
{
    private PostFacade $postFacade;

    public function __construct(PostFacade $postFacade)
    {
        $this->postFacade = $postFacade;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $id = (int) $request->getAttribute('id');
        if ($id <= 0) {
            throw new HttpBadRequestException($request);
        }

        $post = $this->postFacade->getById($id);
        if ($post === null) {
            throw new HttpNotFoundException($request);
        }

        return new JsonResponse([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ]);
    }
}
<?php declare(strict_types=1);

namespace Http\Handler;

use Http\Slim\JsonResponse;
use Post\Post;
use Post\PostFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class CreatePostHandler
{
    private PostFacade $postFacade;

    public function __construct(PostFacade $postFacade)
    {
        $this->postFacade = $postFacade;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $title = (string) ($body['title'] ?? null);
        $content = (string) ($body['content'] ?? null);

        if ($title === '' || $content === '') {
            throw new HttpBadRequestException($request);
        }

        $post = new Post($title, $content);

        $this->postFacade->insert($post);

        return new JsonResponse([
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ]);
    }
}
<?php declare(strict_types=1);

namespace Http\Handler;

use Http\ResponseTranslator\PostResponseTranslator;
use Http\Slim\JsonResponse;
use Post\PostFacade;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class UpdatePostHandler
{
    private PostFacade $postFacade;
    private PostResponseTranslator $postResponseTranslator;

    public function __construct(PostFacade $postFacade, PostResponseTranslator $postResponseTranslator)
    {
        $this->postFacade = $postFacade;
        $this->postResponseTranslator = $postResponseTranslator;
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

        $body = $request->getParsedBody();

        if ( ! array_key_exists('title', $body) && ! array_key_exists('text', $body)) {
            return new JsonResponse(
                $this->postResponseTranslator->translate($post),
                304
            );
        }

        if (array_key_exists('title', $body)) {
            $post->setTitle($body['title']);
        }
        if (array_key_exists('text', $body)) {
            $post->setContent($body['text']);
        }

        $this->postFacade->update($post);

        return new JsonResponse(
            $this->postResponseTranslator->translate($post)
        );
    }
}
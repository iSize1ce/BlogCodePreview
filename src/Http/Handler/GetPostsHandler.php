<?php declare(strict_types=1);

namespace Http\Handler;

use Http\ResponseTranslator\PostResponseTranslator;
use Http\Slim\JsonResponse;
use Post\PostFacade;
use Post\PostSearchTerm;
use Post\PostSearchTerms;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPostsHandler
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
        $titleIs = $request->getQueryParams()['titleIs'] ?? null;
        $contentIs = $request->getQueryParams()['contentIs'] ?? null;

        $titleLike = $request->getQueryParams()['titleLike'] ?? null;
        $contentLike = $request->getQueryParams()['contentLike'] ?? null;

        $titleTerm = null;
        if ($titleIs !== null) {
            $titleTerm = new PostSearchTerm(PostSearchTerm::TYPE_EQUALS, $titleIs);
        } elseif ($titleLike !== null) {
            $titleTerm = new PostSearchTerm(PostSearchTerm::TYPE_LIKE, $titleLike);
        }

        $contentTerm = null;
        if ($contentIs !== null) {
            $contentTerm = new PostSearchTerm(PostSearchTerm::TYPE_EQUALS, $contentIs);
        } elseif ($contentLike !== null) {
            $contentTerm = new PostSearchTerm(PostSearchTerm::TYPE_LIKE, $contentLike);
        }

        $posts = $this->postFacade->search(
            new PostSearchTerms(
                $titleTerm,
                $contentTerm,
            )
        );

        $result = [];
        foreach ($posts as $post) {
            $result[] = $this->postResponseTranslator->translate($post);
        }

        return new JsonResponse($result);
    }
}

<?php declare(strict_types=1);

namespace Http\ResponseTranslator;

use Post\Post;

class PostResponseTranslator
{
    public function translate(Post $post): array
    {
        return [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
        ];
    }
}
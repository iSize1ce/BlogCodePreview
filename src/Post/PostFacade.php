<?php

namespace Post;

class PostFacade
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getById(int $id): ?Post
    {
        return $this->postRepository->getById($id);
    }

    public function update(Post $post): void
    {
    }

    public function insert(Post $post): void
    {
    }
}
<?php declare(strict_types=1);

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
        $this->postRepository->update($post);
    }

    public function insert(Post $post): void
    {
        $this->postRepository->insert($post);
    }

    public function delete(int $id): void
    {
        $this->postRepository->delete($id);
    }
}
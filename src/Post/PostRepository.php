<?php declare(strict_types=1);

namespace Post;

use Doctrine\DBAL\Connection;

class PostRepository
{
    private Connection $dbal;

    public function __construct(Connection $dbal)
    {
        $this->dbal = $dbal;
    }

    public function getById(int $id): ?Post
    {
        $dbRow = $this->dbal->fetchAssoc('SELECT * FROM posts WHERE id = ?', [$id]);
        if ($dbRow === false) {
            return null;
        }

        return $this->createFromDbRow($dbRow);
    }

    public function update(Post $post): void
    {
    }

    public function insert(Post $post): void
    {
    }

    private function createFromDbRow(array $dbRow): Post
    {
        $post = new Post($dbRow['title'], $dbRow['text']);
        $post->setId($dbRow['id']);

        return $post;
    }
}
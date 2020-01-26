<?php

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

    private function createFromDbRow(array $dbRow)
    {
        $post = new Post($dbRow['title'], $dbRow['text']);
        $post->setId($dbRow['id']);

        return $post;
    }
}
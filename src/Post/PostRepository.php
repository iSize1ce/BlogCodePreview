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
        $sql = <<<SQL
UPDATE posts SET
    title = ?,
    content = ?
WHERE id = ?
SQL;

        $this->dbal->query($sql, [$post->getTitle(), $post->getContent(), $post->getId()]);
    }

    public function insert(Post $post): void
    {
        $sql = <<<SQL
INSERT INTO posts SET
    title = ?,
    content = ?
SQL;

        $this->dbal->query($sql, [$post->getTitle(), $post->getContent()]);

        $post->setId((int) $this->dbal->lastInsertId());
    }

    public function delete(int $id): void
    {
        $this->dbal->query('DELETE FROM posts WHERE id = ?', [$id]);
    }

    /**
     * @return Post[]
     */
    public function search(PostSearchTerms $terms): array
    {
        $query = $this->dbal->createQueryBuilder()
            ->select('*')
            ->from('posts');

        $titleTerm = $terms->getTitle();
        if ($titleTerm !== null) {
            if ($titleTerm->isTypeLike()) {
                $query->andWhere('title LIKE ?', $titleTerm);

            } elseif ($titleTerm->isTypeEquals()) {
                $query->andWhere('title = ?', $titleTerm);
            }
        }

        $contentTerm = $terms->getContent();
        if ($contentTerm !== null) {
            if ($contentTerm->isTypeLike()) {
                $query->andWhere('content LIKE ?', $contentTerm);

            } elseif ($contentTerm->isTypeEquals()) {
                $query->andWhere('content = ?', $contentTerm);
            }
        }

        $result = [];
        foreach ($query->execute()->fetchAll() as $dbRow) {
            $result[] = $this->createFromDbRow($dbRow);
        }

        return $result;
    }

    private function createFromDbRow(array $dbRow): Post
    {
        $post = new Post($dbRow['title'], $dbRow['content']);
        $post->setId($dbRow['id']);

        return $post;
    }
}
<?php

namespace Controllers;

use PDO;

class CommentariesController
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function createComment(int $userId, int $postId, string $message): bool
    {

    }

    public function getCommentsByPostId(int $postId): ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM `commentaries` WHERE `post_id` LIKE :post_id');
        $statement->execute([
            'post_id' => $postId
        ]);
        return $statement->fetchAll();
    }
}
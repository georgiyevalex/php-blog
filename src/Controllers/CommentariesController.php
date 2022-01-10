<?php

namespace Controllers;

use Exceptions\PostsException;
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

    /**
     * @param array $params
     * @param array $user
     * @return bool
     * @throws PostsException
     */
    public function createComment(array $params, array $user): bool
    {
        if(empty($params['comment'])) {
            throw new PostsException('Comment must not be empty.');
        }
        $statement = $this->connection->prepare(
            'INSERT INTO `commentaries` (user_id, post_id, published_date, comment) VALUES (:user_id, :post_id, :published_date, :comment)'
        );
        $statement->execute([
            'user_id' => $user['user_id'],
            'post_id' => $params['post_id'],
            'published_date' => date("Y-m-d h:i:s"),
            'comment' => $params['comment']
        ]);
        return true;
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
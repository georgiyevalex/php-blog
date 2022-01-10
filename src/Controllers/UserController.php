<?php

namespace Controllers;

use PDO;

class UserController
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
     * @param int $user_id
     * @return array|null
     */
    public function getUserById(int $user_id): ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM `users` WHERE `user_id` = :user_id');
        $statement->execute([
            'user_id' => $user_id
        ]);

        return $statement->fetchAll();
    }
}
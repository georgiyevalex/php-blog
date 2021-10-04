<?php

namespace Controllers;

use PDO;

class SearchController
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
     * @param string $searchText
     * @return array|null
     */
    public function searchPostByText(string $searchText) : ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM `post` WHERE `title` LIKE :search_text OR `content` LIKE :search_text OR `description` LIKE :search_text');
        $statement->execute([
            'search_text' => '%' . $searchText . '%'
        ]);
        return $statement->fetchAll();
    }

}
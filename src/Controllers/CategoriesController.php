<?php


namespace Controllers;

use PDO;

class CategoriesController
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
     * @return array|null
     */
    public function getAllCategories() : ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM `category` ');
        $statement->execute();

        return $statement->fetchAll();
    }
}
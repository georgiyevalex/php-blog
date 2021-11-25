<?php

namespace Controllers;

use Exceptions\PostsException;
use PDO;

class PostsController
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
     * @param string $urlKey
     * @return array|null
     */
    public function getPostByUrlKey(string $urlKey) : ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM `post` WHERE `url_key` = :url_key');
        $statement->execute([
           'url_key' => $urlKey
        ]);
        $result = $statement->fetchAll();

        return array_shift($result);
    }

    /**
     * @param string $direction
     * @return array|null
     * @throws PostsException
     */
    public function getAllPosts(string $direction) : ?array
    {
        if(!in_array($direction, ['DESC', 'ASC'])) {
            throw new PostsException('The direction is not supported.');
        }
        $statement = $this->connection->prepare('SELECT * FROM `post` ORDER BY `published_date` ' . $direction);
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param array $params
     * @return bool
     * @throws PostsException
     */
    public function createPost(array $params) : bool {
        if(empty($params['title'])) {
            throw new PostsException('Title must not be empty.');
        }
        if(empty($params['content'])) {
            throw new PostsException('Content must not be empty.');
        }
        if(empty($params['description'])) {
            throw new PostsException('Description must not be empty.');
        }
        if(empty($params['url_key'])) {
            throw new PostsException('url_key must not be empty.');
        }
        if(preg_match("/^[a-z\d\-]+$/", $params['url_key'])) {

        } else {
            throw new PostsException('the field can contain lowercase letters, numbers and a sign "-" ');
        }

        $statement = $this->connection->prepare(
            'SELECT * FROM `post` WHERE `url_key` = :url_key'
        );
        $statement->execute([
            'url_key' => $params['url_key']
        ]);
        $post = $statement->fetch();
        if (!empty($post)) {
            throw new PostsException('post with such url_key exsists');
        }

        $statement = $this->connection->prepare(
            'INSERT INTO `post` (title, description, content, image_path, url_key, published_date) VALUES (:title, :description, :content, :image_path, :url_key, :published_date)'
        );
        $statement->execute([
            'title' => $params['title'],
            'description' => $params['description'],
            'content' => $params['content'],
            'image_path' => $params['image_path'] ?: null,
            'url_key' => $params['url_key'],
            'published_date' => date("Y-m-d h:i:s")
        ]);
        return true;
    }
}
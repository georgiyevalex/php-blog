<?php

namespace Controllers;

use Blog\ImagePath;
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
     * @param string $category_name
     * @return int|null
     */
    private function getCategoryID(string $category_name) : ?int
    {
        $statement = $this->connection->prepare('SELECT * FROM `category` WHERE `category_name` = :category_name');
        $statement->execute([
            'category_name' => $category_name
        ]);

        $category = $statement->fetchAll();
        $category = array_shift($category);
        return $category['category_id'];
    }

    private function addPostImage(string $imagePath, int $postId) :?bool
    {
        $statement = $this->connection->prepare('UPDATE `post` SET `image_path` = :image_path WHERE `post_id` = :post_id');
        $statement->execute([
            'post_id' => $postId,
            'image_path' => $imagePath ? '/' . $postId . '/' . $imagePath : null,
        ]);
        return true;
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
     * @param int $page
     * @param int $pagePostsLimit
     * @param string $direction
     * @return array|null
     * @throws PostsException
     */
    public function getAllPosts(int $page, int $pagePostsLimit, string $direction) : ?array
    {
        if(!in_array($direction, ['DESC', 'ASC'])) {
            throw new PostsException('The direction is not supported.');
        }
        $start = ($page - 1) * $pagePostsLimit;
        $statement = $this->connection->prepare(
            'SELECT * FROM `post` ORDER BY `published_date` ' . $direction .
            ' LIMIT ' . $start . ',' .$pagePostsLimit
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    /**
     * @param int $page
     * @param int $pagePostsLimit
     * @param string $category_name
     * @param string $direction
     * @return array|null
     * @throws PostsException
     */
    public function getPostsByCategory(int $page, int $pagePostsLimit, string $category_name, string $direction) : ?array
    {
        if(!in_array($direction, ['DESC', 'ASC'])) {
            throw new PostsException('The direction is not supported.');
        }

        $start = ($page - 1) * $pagePostsLimit;
        $statement = $this->connection->prepare(
            'SELECT * FROM `post` WHERE `category` = :category ORDER BY `published_date` ' . $direction .
            ' LIMIT ' . $start . ',' .$pagePostsLimit
        );
        $statement->execute([
            'category' => $this->getCategoryID($category_name)
        ]);

        return $statement->fetchAll();
    }

    /**
     * @param string $category_name
     * @return int
     */
    public function getTotalPostCount(string $category_name) : int
    {
        if($category_name) {
            $statement = $this->connection->prepare('SELECT count(`post_id`) as `total` FROM `post` WHERE `category` = :category');
            $statement->execute([
                'category' => $this->getCategoryID($category_name)
            ]);
            return (int) ($statement->fetchColumn() ?? 0);
        } else {
            $statement = $this->connection->prepare('SELECT count(`post_id`) as `total` FROM `post`');
            $statement->execute();
            return (int) ($statement->fetchColumn() ?? 0);
        }
    }

    /**
     * @param array $params
     * @param array $user
     * @return bool
     * @throws PostsException
     */
    public function createPost(array $params, array $user) : bool {
        if(empty($params['title'])) {
            throw new PostsException('Title must not be empty.');
        }
        if(empty($params['content'])) {
            throw new PostsException('Content must not be empty.');
        }
        if(empty($params['description'])) {
            throw new PostsException('Description must not be empty.');
        }
        if(empty($params['image_path'])) {
            throw new PostsException('Image must not be empty.');
        }
        if(empty($params['url_key'])) {
            throw new PostsException('url_key must not be empty.');
        }
        if(empty($params['category'])) {
            throw new PostsException('category must not be empty.');
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
            'INSERT INTO `post` (title, description, content, url_key, category, published_date, author_id) VALUES (:title, :description, :content, :url_key, :category, :published_date, :author_id)'
        );
        $statement->execute([
            'title' => $params['title'],
            'description' => $params['description'],
            'content' => $params['content'],
            'url_key' => $params['url_key'],
            'category' => $params['category'],
            'published_date' => date("Y-m-d h:i:s"),
            'author_id' => $user['user_id']
        ]);

        var_dump($this->connection->lastInsertId());
        $this->addPostImage($params['image_path'], $this->connection->lastInsertId());
        return true;
    }
}
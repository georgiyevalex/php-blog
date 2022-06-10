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

    /*private function addPostImage(string $imagePath, int $postId) :?bool
    {
        $statement = $this->connection->prepare('UPDATE `post` SET `image_path` = :image_path WHERE `post_id` = :post_id');
        $statement->execute([
            'post_id' => $postId,
            'image_path' => $imagePath ? '/' . $postId . '/' . $imagePath : null,
        ]);
        return true;
    }*/

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
     * @param array $post_data
     * @param object
     * @param array $user
     * @return bool
     * @throws PostsException
     */
    public function createPost(array $post_data, ?object $file, array $user) : bool {
        if(!$post_data['title']) {
            throw new PostsException('Title must not be empty.');
        }
        if(!$post_data['content']) {
            throw new PostsException('Content must not be empty.');
        }
        if(!$post_data['description']) {
            throw new PostsException('Description must not be empty.');
        }
        if(!$post_data['url_key']) {
            throw new PostsException('url_key must not be empty.');
        }
        if(preg_match("/^[a-z\d\-]+$/", $post_data['url_key'])) {

        } else {
            throw new PostsException('the field can contain lowercase letters, numbers and a sign "-" ');
        }
        if(!$post_data['category']) {
            throw new PostsException('category must not be empty.');
        }

        $statement = $this->connection->prepare(
            'SELECT true FROM `post` WHERE `url_key` = :url_key'
        );
        $statement->execute([
            'url_key' => $post_data['url_key']
        ]);
        $existing_post = $statement->fetch();
        if ($existing_post) {
            throw new PostsException('post with such url_key exsists');
        }

        $statement = $this->connection->prepare(
            'INSERT INTO `post` (title, description, content, url_key, category, published_date, author_id) VALUES (:title, :description, :content, :url_key, :category, :published_date, :author_id)'
        );
        $statement->execute([
            'title' => $post_data['title'],
            'description' => $post_data['description'],
            'content' => $post_data['content'],
            'url_key' => $post_data['url_key'],
            'category' => $post_data['category'],
            'published_date' => date("Y-m-d h:i:s"),
            'author_id' => $user['user_id']
        ]);

        if($file !== NULL) {
            $postId = $this->connection->lastInsertId();
            $fileExt = 'png';
            try {
                $file->move(ImagePath::POST_IMAGE_PATH, $postId . '.' . $fileExt);
                    } catch (FileException $exception) {

            }

            $statement = $this->connection->prepare('UPDATE `post` SET `image_path` = :image_path WHERE `post_id` = :post_id');
            $statement->execute([
                'post_id' => $postId,
                'image_path' => ImagePath::POST_IMAGE_PATH ? ImagePath::POST_IMAGE_PATH . $postId . '.' . $fileExt: null,
            ]);
        }
        return true;
    }
}

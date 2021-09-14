<?php

namespace Controllers;

use Exceptions\AuthorizationException;
use App\Session;
use PDO;

class AuthorizationController
{
    /**
     * @var PDO
     */
    private PDO $connection;

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @param PDO $connection
     * @param Session $session
     */
    public function __construct(PDO $connection, Session $session)
    {
        $this->connection = $connection;
        $this->session = $session;
    }

    /**
     * @param array $params
     * @return bool
     * @throws AuthorizationException
     */
    public function register(array $params): bool
    {
        if(empty($params['first_name'])) {
            throw new AuthorizationException('The first name should not be empty');
        }
        if(empty($params['last_name'])) {
            throw new AuthorizationException('The last name should not be empty');
        }
        if(empty($params['email'])) {
            throw new AuthorizationException('The email should not be empty');
        }
        if(empty($params['password'])) {
            throw new AuthorizationException('The password should not be empty');
        }
        if($params['password'] !== $params['confirm_password']) {
            throw new AuthorizationException('The password and confirm should match');
        }

        $statement = $this->connection->prepare(
            'SELECT * FROM `users` WHERE `email` = :email'
        );
        $statement->execute([
            'email' => $params['email']
        ]);
        $user = $statement->fetch();
        if (!empty($user)) {
            throw new AuthorizationException('User with such email exsists');
        }

        $statement = $this->connection->prepare(
            'INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)'
        );
        $statement->execute([
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'email' => $params['email'],
            'password' => password_hash($params['password'], PASSWORD_BCRYPT),
        ]);
        return true;
    }

    /**
     * @param array $params
     * @return bool
     * @throws AuthorizationException
     */
    public function login(array $params): bool
    {
        if(empty($params['email'])) {
            throw new AuthorizationException('The email should not be empty');
        }
        if(empty($params['password'])) {
            throw new AuthorizationException('The password should not be empty');
        }

        $statement = $this->connection->prepare(
            'SELECT * FROM `users` WHERE `email` = :email'
        );
        $statement->execute([
            'email' => $params['email']
        ]);
        $user = $statement->fetch();
        if (empty($user)) {
            throw new AuthorizationException('User with such email not exsists');
        }
        if(password_verify($params['password'], $user['password'])) {
            $this->session->setData('user', [
                'user_id' => $user['user_id'],
                'username' => $user['first_name'],
                'email' => $user['email']
            ]);
            $this->session->save();
            return true;
        }
        throw new AuthorizationException('Incorrect email or password');
    }

}
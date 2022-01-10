<?php

namespace Controllers;

use Blog\Destination;
use App\Session;
use Exceptions\AuthorizationException;
use Exceptions\PostsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Smarty;
use PDO;

class MainController
{
    /**
     * @var Request
     */
    private Request $request;
    /**
     * @var Response
     */
    private Response $response;
    /**
     * @var Smarty
     */
    private Smarty $smarty;
    /**
     * @var PDO
     */
    private PDO $connection;


    /**
     * @param Request $request
     * @param Response $response
     * @param Smarty $smarty
     * @param PDO $connection
     */
    public function __construct(Request $request, Response $response, Smarty $smarty, PDO $connection)
    {
        $this->request = $request;
        $this->response = $response;
        $this->smarty = $smarty;
        $this->connection = $connection;
    }

    /**
     * @throws \SmartyException
     */
    public function __invoke() :void
    {
        $session = new Session();
        $session->start();

        $postMapper = new PostsController($this->connection);
        $authorization = new AuthorizationController($this->connection, $session);
        $search = new SearchController($this->connection);
        $categories = new CategoriesController($this->connection);
        $commentaries = new CommentariesController($this->connection);
        $userController = new UserController($this->connection);
        $routes = new RouteCollection();

        $data = [];
        $data['user'] = $session->getData('user');

        $pagePostsLimit = 6;

        $_routes = [
            '/' => function () use ($pagePostsLimit, $postMapper, $categories, &$data) {
                $page = $this->request->query->getInt('page') ?: 1;
                $totalPostsCount = $postMapper->getTotalPostCount('');
                $data['posts'] = $postMapper->getAllPosts($page, $pagePostsLimit, 'DESC');
                $data['url'] = Destination::DESTINATION_HOME;
                $data['categories'] = $categories->getAllCategories();
                $data['pagination'] = [
                    'current' =>  $page,
                    'paging' => ceil($totalPostsCount / $pagePostsLimit)
                ];
                $data['main_page'] = 1;
            },
            '/categories/{category}' => function () use ($pagePostsLimit, $postMapper, $categories, &$data) {
                $path = pathinfo($this->request->getPathInfo());
                $category = $path['basename'];
                $page = $this->request->query->getInt('page') ?: 1;
                $totalPostsCount = $postMapper->getTotalPostCount($category);
                $data['categories'] = $categories->getAllCategories();
                $data['current_category'] = $path['basename'];
                $data['posts'] = $postMapper->getPostsByCategory($page, $pagePostsLimit, $category, 'DESC');
                $data['url'] = Destination::DESTINATION_HOME;
                $data['pagination'] = [
                    'current' =>  $page,
                    'paging' => ceil($totalPostsCount / $pagePostsLimit)
                ];
                $data['category_page'] = 1;
            },
            '/about' => function () use (&$data) {
                $data['url'] = Destination::DESTINATION_ABOUT;
            },
            '/new-post' => function () use ($session, $categories, &$data) {
                if($data['user'] == null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                $data['url'] = Destination::DESTINATION_NEW_POST;
                $data['message'] = $session->flush('post_message');
                $data['post'] = $session->flush('post');
                $data['categories'] = $categories->getAllCategories();

            },
            '/create-post' => function () use ($postMapper, $session, &$data) {
                parse_str($this->request->getContent(), $params);
                var_dump($params);
                var_dump($this->request->files);

                try {
                    $postMapper->createPost($params, $data['user']);
                } catch (PostsException $exception) {
                    $session->setData('post_message', $exception->getMessage());
                    $session->setData('post', $params);
                    $session->save();
                    $this->response = new RedirectResponse('/new-post');
                    $this->response->send();
                }

                $this->response = new RedirectResponse("/posts/$params[url_key]");
                $this->response->send();
            },
            '/posts/{url_key}' => function () use ($session, $userController, $commentaries, $postMapper, &$data) {
                $path = pathinfo($this->request->getPathInfo());
                $url_key = $path['basename'];
                $post = $postMapper->getPostByUrlKey($url_key);
                if($post) {
                    $data['url'] = Destination::DESTINATION_POSTS;
                    $data['post'] = $post;
                    $data['message'] = $session->flush('comment_message');
                    $comments = $commentaries->getCommentsByPostId($post['post_id']);
                    foreach ($comments as $key => $comment) {
                        $data['commentaries'][$key] = $comment;
                        $user = $userController->getUserById($comment['user_id']);
                        $data['commentaries'][$key]['user'] = $user[0]['first_name'] . ' ' . $user[0]['last_name'];
                    }
                }
            },
            '/add-comment' => function () use ($session, $postMapper, $commentaries, &$data) {
                if($data['user'] == null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                parse_str($this->request->getContent(), $params);

                try {
                    $commentaries->createComment($params, $data['user']);
                } catch (PostsException $exception) {
                    $session->setData('comment_message', $exception->getMessage());
                    $session->save();
                    $this->response = new RedirectResponse("/posts/$params[url_key]");
                    $this->response->send();
                }
                $this->response = new RedirectResponse("/posts/$params[url_key]");
                $this->response->send();
            },
            '/registration' => function () use ($session, &$data) {
                if($data['user'] != null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                $data['url'] = Destination::DESTINATION_REGISTRATION;
                $data['message'] = $session->flush('message');
                $data['form'] = $session->flush('form');
            },
            '/profile' => function () use ($session, &$data) {
                if($data['user'] == null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                $data['url'] = Destination::DESTINATION_PROFILE;
            },
            '/register' => function () use ($authorization, $session, &$data) {
                if($data['user'] != null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                parse_str($this->request->getContent(), $params);

                try {
                    $authorization->register($params);
                } catch (AuthorizationException $exception) {
                    $session->setData('message', $exception->getMessage());
                    $session->setData('form', $params);
                    $session->save();
                    $this->response = new RedirectResponse('/registration');
                    $this->response->send();
                }

                $this->response = new RedirectResponse('/');
                $this->response->send();
            },
            '/login' => function () use ($session, &$data) {
                if($data['user'] != null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                $data['url'] = Destination::DESTINATION_LOGIN;
                $data['message'] = $session->flush('message');
                $data['form'] = $session->flush('form');
            },
            '/login-page' => function () use ($authorization, $session, &$data) {
                if($data['user'] != null) {
                    $this->response = new RedirectResponse('/');
                    $this->response->send();
                }

                parse_str($this->request->getContent(), $params);
                try {
                    $authorization->login($params);
                } catch (AuthorizationException $exception) {
                    $session->setData('message', $exception->getMessage());
                    $session->setData('form', $params);
                    $session->save();
                    $this->response = new RedirectResponse('/login');
                    $this->response->send();
                }

                $this->response = new RedirectResponse('/');
                $this->response->send();
            },
            '/logout' => function () use ($session) {
                $session->setData('user', null);
                $this->response = new RedirectResponse('/');
                $this->response->send();
            },
            '/search' => function () use ($search, &$data) {
                $data['url'] = Destination::DESTINATION_SEARCH;
                $searchText = $this->request->get('search_text');

                $searchResult = $search->searchPostByText($searchText);

                $data['posts'] = $searchResult;
                $data['search_text'] = $searchText;

            }
        ];

        $_route_index = 0;

        foreach ($_routes as $path => $controller) {
            $routes->add('route_' . ++$_route_index, new Route($path, ['_controller' => $controller]));
        }

        try {
            $route = (new UrlMatcher($routes, (new RequestContext())->fromRequest($this->request)))
                ->matchRequest($this->request);

            $controller = $route['_controller'];
            unset($route['_controller']);

            $controller($route);
        } catch (ResourceNotFoundException $e) {
            error_log($e);
        }

        $this->smarty->assign($data);
        $this->smarty->display('index.tpl');
    }
}
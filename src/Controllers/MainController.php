<?php

namespace Controllers;

use Blog\Destination;
use Controllers\PostsController;
use Controllers\AuthorizationController;
use Controllers\SearchController;
use App\Session;
use Exceptions\AuthorizationException;
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

    public function __invoke()
    {
        $session = new Session();
        $session->start();

        $postMapper = new PostsController($this->connection);
        $authorization = new AuthorizationController($this->connection, $session);
        $search = new SearchController($this->connection);
        $routes = new RouteCollection();
        $data = [];
        $data['user'] = $session->getData('user');

        $_routes = [
            '/' => function () use ($postMapper, &$data) {
                $data['posts'] = $postMapper->getAllPosts('DESC');
                $data['url'] = Destination::DESTINATION_HOME;
            },
            '/about' => function () use (&$data) {
                $data['url'] = Destination::DESTINATION_ABOUT;
            },
            'posts/create-post' => function () use ($session, &$data) {
                $data['url'] = Destination::DESTINATION_CREATE_POST;
                $data['message'] = $session->flush('message');
                $data['post'] = $session->flush('post');
            },
            '/posts/{url_key}' => function () use ($postMapper, &$data) {
                $url_key = ltrim($this->request->getPathInfo(), '/posts/');
                $post = $postMapper->getPostByUrlKey($url_key);
                if($post) {
                    $data['url'] = Destination::DESTINATION_POSTS;
                    $data['post'] = $post;
                }
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
                    echo $exception->getMessage();
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
                    echo $exception->getMessage();
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
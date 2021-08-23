<?php

namespace Controllers;

use Blog\Destination;
use Controllers\PostsController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Smarty;

class MainController
{
    /**
     * @var $request
     */
    private $request;
    /**
     * @var $smarty
     */
    private  $smarty;
    /**
     * @var $connection;
     */
    private $connection;


    public function __construct($request, $smarty, $connection)
    {
        $this->request = $request;
        $this->smarty = $smarty;
        $this->connection = $connection;
    }

    public function __invoke()
    {

        $postMapper = new PostsController($this->connection);


        $routes = new RouteCollection();
        $data = [];

        $_routes = [
            '/' => function () use ($postMapper, &$data) {
                $data['posts'] = $postMapper->getAllPosts('DESC');
                $data['url'] = Destination::DESTINATION_HOME;

            },
            '/about' => function () use (&$data) {
                $data['url'] = Destination::DESTINATION_ABOUT;
            },
            '/{url_key}' => function () use ($postMapper, &$data) {
                $url_key = ltrim($_SERVER[REQUEST_URI], '/');
                $post = $postMapper->getPostByUrlKey($url_key);
                $data['url'] = Destination::DESTINATION_POSTS;
                if($post) {
                    $data['post'] = $post;
                } else {
                    $data['url'] = '';
                }

            },
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
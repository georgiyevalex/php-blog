<?php

use Controllers\MainController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__ . '/../bootstrap.php';

$request = new Request(
    $_GET,
    $_POST,
    [],
    $_COOKIE,
    $_FILES,
    $_SERVER
);

$response = new Response();

/** @noinspection PhpUnhandledExceptionInspection */
(new MainController(
    $request,
    $response,
    $smarty,
    $connection
))();
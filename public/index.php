<?php

use Controllers\MainController;
use Symfony\Component\HttpFoundation\Request;
require_once __DIR__ . '/../bootstrap.php';

    $request = new Request(
    $_GET,
    $_POST,
    [],
    $_COOKIE,
    $_FILES,
    $_SERVER
);

(new MainController($request, $smarty, $connection))();
<?php

error_reporting(E_ALL);
ini_set('display_errors', 0);

use Controllers\PostsController;

require __DIR__ . '/vendor/autoload.php';

$config = require_once __DIR__. '/config/dbConnect.php';
$dsn = $config['dsn'];
$username = $config['username'];
$password = $config['password'];

try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    echo 'Database error: ' . $exception->getMessage();
    exit();
}


$smarty = new Smarty();

$smarty->setTemplateDir(__DIR__ .  '/templates');
$smarty->setCompileDir(__DIR__ . '/var/templates/compiled');
$smarty->addPluginsDir(__DIR__ . '/resources/smarty/plugins');

$smarty->setErrorReporting(E_ALL & ~E_NOTICE);
//$smarty->setDebugging(true);

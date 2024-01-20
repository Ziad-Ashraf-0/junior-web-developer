<?php
require_once 'config.php';
require_once __DIR__ . '/vendor/autoload.php';

use Controller\MyController;


if ($_GET['url'] === 'endpoint') 
{
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $controller = new MyController($requestMethod);
    $controller->req();
}


?>

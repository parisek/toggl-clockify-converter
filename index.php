<?php

// https://www.taniarascia.com/the-simplest-php-router/

if (@!include __DIR__ . '/vendor/autoload.php') {
  die('Install packages using `composer install`');
}

$request = $_SERVER['REQUEST_URI'];
$url = parse_url($request);

switch ($url['path']) {
  case '/clients':
    require __DIR__ . '/clients.php';
    break;
  case '/projects':
    require __DIR__ . '/projects.php';
    break;
  case '/tasks':
    require __DIR__ . '/tasks.php';
    break;
  case '/export':
    require __DIR__ . '/export.php';
    break;
  case '/':
    require __DIR__ . '/home.php';
    break;
  default:
    http_response_code(404);
    break;
}

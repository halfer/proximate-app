<?php

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();

// Url browser
$app->get('/', function ($request, $response) {

    $curl = new PestJSON("http://proximate-api:8080/");
    $data = $curl->get('/count');
    print_r($data);
});
$app->run();

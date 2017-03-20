<?php

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();
$templates = new League\Plates\Engine($root . '/src/views');

// Url browser
$app->get('/', function ($request, $response) use ($templates) {

    $curl = new PestJSON("http://proximate-api:8080/");
    $data = $curl->get('/count');

    echo $templates->render(
        'urls',
        ['count' => $data['result']['count']]
    );
});
$app->run();

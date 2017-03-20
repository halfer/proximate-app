<?php

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();
$templates = new League\Plates\Engine($root . '/src/views');

// Url browser
$app->get('/', function ($request, $response) use ($templates) {

    $curl = new PestJSON("http://proximate-api:8080/");
    // Check that result.ok = true for each of these
    $countData = $curl->get('/count');
    $listData = $curl->get('/play/list');

    echo $templates->render(
        'urls',
        [
            'count' => $countData['result']['count'],
            'list' => $listData['result']['list'],
        ]
    );
});
$app->run();

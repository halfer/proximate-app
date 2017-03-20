<?php

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();
$templates = new League\Plates\Engine($root . '/src/views');

$listController = function ($request, $response, $args) use ($templates) {

    // If we have a page ref then use it
    $page = isset($args['page']) ?
        (int) $args['page'] :
        1;

    $curl = new PestJSON("http://proximate-api:8080/");
    // @todo Check that result.ok = true for each of these
    $countData = $curl->get('/count');
    $listData = $curl->get('/play/list/' . $page);

    echo $templates->render(
        'urls',
        [
            'count' => $countData['result']['count'],
            'list' => $listData['result']['list'],
            'pageSize' => 10,
        ]
    );
};

// Url browser
$app->get('/', $listController);
$app->get('/list/{page}', $listController);
$app->run();

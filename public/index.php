<?php

use Slim\Http\Request;
use Slim\Http\Response;

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();
$templates = new League\Plates\Engine($root . '/src/views');

// Prep an instance of the curl system
$curl = new PestJSON("http://proximate-api:8080/");

$listController = function (Request $request, Response $response, $args) use ($templates, $curl) {

    // If we have a page ref then use it
    $page = isset($args['page']) ?
        (int) $args['page'] :
        1;

    // Defaults in case of error condition
    $countData = 0;
    $listData = [];

    $error = null;
    try
    {
        $data = $curl->get('/count');
        if (isset($data['result']['count']))
        {
            $countData = $data['result']['count'];
        }
    }
    catch (\Pest_ServerError $e)
    {
        $error = "The count endpoint failed";
    }

    if (!$error)
    {
        try
        {
            $data = $curl->get('/play/list/' . $page);
            if (isset($data['result']['list']))
            {
                $listData = $data['result']['list'];
            }
        }
        catch (\Pest_ServerError $e)
        {
            $error = "The count endpoint failed";
        }
    }

    $html = $templates->render(
        'urls',
        [
            'count' => $countData,
            'list' => $listData,
            'pageSize' => 10,
            'error' => $error,
        ]
    );
    $response->getBody()->write($html);

    return $response;
};

// Url browser
$app->get('/', $listController);
$app->get('/list/{page}', $listController);

$app->post('/delete/{id}', function(Request $request, Response $response, $args) use ($curl) {

    // Get the ID of the item to delete
    $id = isset($args['id']) ? $args['id'] : null;

    $error = null;
    if ($id)
    {
        try
        {
            $curl->delete('/cache/' . $id);
        }
        catch (\Pest_ServerError $e)
        {
            $error = "The delete operation failed";
            // @todo Add the error into a flash variable
        }
    }

    // The Slim way doesn't seem to work, so doing it manually
    return $response->
        withStatus(303)->
        withRedirect('/');
});

$app->get('/status', function(Request $request, Response $response) use ($templates, $curl) {

    $statusData = [];
    $error = null;
    try
    {
        $data = $curl->get('/status');
        if (isset($data['result']['recorder']['sites']))
        {
            $statusData = $data['result']['recorder']['sites'];
        }
    }
    catch (\Pest_ServerError $e)
    {
        $error = "The status endpoint failed";
    }

    $html = $templates->render(
        'status',
        ['sites' => $statusData, 'error' => $error, ]
    );
    $response->getBody()->write($html);

    return $response;
});

$app->run();

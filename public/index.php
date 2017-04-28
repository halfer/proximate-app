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
            $data = $curl->get('/list/' . $page);
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

$app->get('/view/{id}', function(Request $request, Response $response, $args) use ($templates, $curl) {

    // Get the ID of the item to show
    $id = isset($args['id']) ? $args['id'] : null;

    $error = null;
    $cacheItem = null;
    try
    {
        $data = $curl->get('/cache/' . $id);
        if (isset($data['result']['item']))
        {
            $cacheItem = $data['result']['item'];
        }
    }
    catch (\Pest_ServerError $e)
    {
        $error = "The get cache item endpoint failed";
    }

    $html = $templates->render(
        'view',
        [
            'cacheItem' => $cacheItem,
        ]
    );
    $response->getBody()->write($html);

    return $response;
});

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

$app->get('/crawl', function (Request $request, Response $response) use ($templates) {
    $html = $templates->render('crawl');
    $response->getBody()->write($html);

    return $response;
});

$app->post('/crawl/go', function (Request $request, Response $response) use ($curl) {

    $crawlRequest = [
        'url' => $request->getParam('url'),
        'path_regex' => $request->getParam('path_regex')
    ];
    $result = $curl->post('/cache', $crawlRequest);
    print_r($result);

    return $response->
        withStatus(303)->
        withRedirect('/');
});

$app->get('/proxy-test', function (Request $request, Response $response) use ($templates) {

    $targetSite = 'http://proximate-app:8084/test-target';
    $elements = parse_url($targetSite);
    $siteRoot = $elements['scheme'] . '://' . $elements['host'] . ':' . $elements['port'];

    // @todo Inject this dependency into the anonymous function
    $curlSelf = new Pest($siteRoot);

    // Fetch the target page
    // @todo Wrap this in Pest_Curl_Exec to catch connection refused errors
    // @todo Need to run this through the proxy
    $html = $curlSelf->get($elements['path']);
    $response->getBody()->write($html);

    // @todo Wire in the template
    $html2 = $templates->render(
        'proxy-test',
        ['proxyAddress' => '', 'targetSite' => '', 'ok' => true, ]
    );

    return $response;
});

$app->get('/test-target', function (Request $request, Response $response) {

    $html = rand(1, 1000);
    $response->getBody()->write($html);

    return $response;
});

$app->run();

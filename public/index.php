<?php
/**
 * Front controller for simple app to control a Proximate instance
 *
 * @todo Swap Pest library to the Curl library, which is more flexible
 */

use Slim\Http\Request;
use Slim\Http\Response;

$root = realpath(__DIR__ . '/..');
require_once $root . '/vendor/autoload.php';

$app = new \Slim\App();
$templates = new League\Plates\Engine($root . '/src/views');

// Prep an instance of the curl system (old style)
$curl = new PestJSON("http://proximate-api:8080/");

// Set up new style curl object
$proxyAddress = "proximate-proxy:8081";
$curlSelf = new Curl\Curl();
$curlSelf->setOpt(CURLOPT_CONNECTTIMEOUT, 1);
$curlSelf->setOpt(CURLOPT_TIMEOUT, 3);
$curlSelf->setOpt(CURLOPT_PROXY, $proxyAddress);

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
            // @todo Ensure that this contains ok = true
            $curlResponse = $curl->delete('/cache/' . $id);
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

$app->get('/proxy/test', function (Request $request, Response $response)
    use ($templates, $curlSelf, $proxyAddress) {

    // Fetch the target page
    // @todo Wrap this in try-catch to catch connection refused errors
    $targetSite = 'http://proximate-app:8085/proxy/test-target';
    $html = $curlSelf->get($targetSite)->response;
    $ok = $curlSelf->http_status_code === 200;

    $error = '';
    if (!$ok)
    {
        // Example of a curl error: "Port number out of range"
        // Example of an HTTP error: "Server error"
        $error = $curlSelf->curl_error_message ?
            $curlSelf->curl_error_message :
            $curlSelf->http_error_message;
    }

    // Wire in the template
    $renderHtml = $templates->render(
        'proxy-test',
        ['proxyAddress' => $proxyAddress, 'targetSite' => $targetSite,
         'ok' => $ok, 'byteCount' => $ok ? strlen($html) : 0,
         'error' => $error, ]
    );
    $response->getBody()->write($renderHtml);

    return $response;
});

$app->get('/proxy/test-target', function (Request $request, Response $response) {

    $html = rand(1, 1000);
    $response->getBody()->write($html);

    return $response;
});

$app->get('/proxy/log', function (Request $request, Response $response) use ($curl, $templates) {

    $log = $curl->get('/log');
    $html = $templates->render('proxy/log', ['log' => $log, ]);
    $response->getBody()->write($html);

    return $response;
});

$app->run();

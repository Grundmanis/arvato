<?php

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $kernel = new Kernel($_SERVER['APP_ENV'], (bool) $_SERVER['APP_DEBUG']);

    // Wrap kernel in HttpCache only in prod or when you want caching
    // if ($_SERVER['APP_ENV'] === 'prod') {
    $kernel = new HttpCache($kernel);
    // }

    $request = Symfony\Component\HttpFoundation\Request::createFromGlobals();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
};

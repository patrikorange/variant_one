<?php

error_reporting(0);

use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Events\Manager;

try {

    $di = new Phalcon\Di;

    include __DIR__ . '/../Config/services.php';

    $loader = new Loader();

    $loader->registerClasses(
        [
            'UserController'        => __DIR__ .'/../Controllers/UserController.php',
            'RequestMiddleware'     => __DIR__ .'/../Middleware/RequestMiddleware.php',
            'ResponseMiddleware'    => __DIR__ .'/../Middleware/ResponseMiddleware.php',
            'Users'                 => __DIR__ .'/../Models/Users.php',
        ]
    );

    $loader->register();

    $eventsManager = new Manager();
    $eventsManager->attach('micro', new RequestMiddleware());
    $eventsManager->attach('micro', new ResponseMiddleware());

    $app = new Micro();

    $app->setDI($di);
    $app->setEventsManager($eventsManager);
    $app->setModelBinder(new \Phalcon\Mvc\Model\Binder());

    #Check request format
    $app->before(
        new RequestMiddleware()
    );

    #Response into JSON-RPC2.0 format
    $app->after(
        new ResponseMiddleware()
    );

    $app->notFound(
        function () use ($app) {
            throw new \Phalcon\Exception('Method not found', -32601);
        }
    );

    $app->handle();

} catch (Exception $ex) {
    echo json_encode(
        [
            'jsonrpc' => '2.0',
            'error' => [
                'code'    => $ex->getCode(),
                'message' => $ex->getMessage(),
            ],
            'id' => $app->router->id
        ]
    );
}
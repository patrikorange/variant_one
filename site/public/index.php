<?php

    use Phalcon\Mvc\Micro;
    use Phalcon\Mvc\Micro\Collection as MicroCollection;
    use Phalcon\Loader;
    use Controllers\IndexController;

    $di = new Phalcon\Di;

    include __DIR__ . '/../Config/services.php';

    $loader = new Loader();

    $loader->registerNamespaces(array(
        'Controllers' => __DIR__ . '/../Controllers/',
        'Forms' => __DIR__ . '/../Forms/',
        'Library' => __DIR__ . '/../Library/',
    ))->register();

    $app = new Micro();

    $app->setDI($di);

    $index = new MicroCollection();
    $index->setHandler(
        new IndexController()
    );
    $index->get('/', 'indexAction');
    $index->post('/login', 'login');

    $app->mount($index);

    $app->error(
        function ($exception) {
            echo json_encode(
                [
                    'code'    => $exception->getCode(),
                    'status'  => 'error',
                    'message' => $exception->getMessage(),
                ]
            );
        }
    );

    $app->handle();



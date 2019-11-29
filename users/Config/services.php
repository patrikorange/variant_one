<?php


$di->setShared('config', function () {
    return include __DIR__. "/../Config/config.php";

});

$config  = $di->getShared('config');

$di->setShared('db', function () {
    $config = $this->getConfig();
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $params = [
        'dbname'   => $config->database->dbname,
    ];
    $connection = new $class($params);
    return $connection;
});

$di->setShared('url', function () {
    $url = new Phalcon\Mvc\Url();
    return $url;
});

$di->setShared('request', function() {
    return new Phalcon\Http\Request();
});

$di->setShared('router', function () {
    return new Phalcon\Mvc\Router();
});

$di->setShared('response', function() {
    return new Phalcon\Http\Response();
});

$di->set('modelsManager', function () {
    $modelsManager = new Phalcon\Mvc\Model\Manager();
    return $modelsManager;
});

$di->setShared('modelsMetadata', function () {
    return new Phalcon\Mvc\Model\Metadata\Memory();
});
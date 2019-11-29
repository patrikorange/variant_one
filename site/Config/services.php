<?php

$di->setShared('session',
    function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();

        return $session;
    });

$di->set(
    'flash',
    function () {
        $flash = new \Phalcon\Flash\Direct( array(
            'warning'     => 'alert alert-warning',
            'notice'      => 'alert alert-info',
            'success'     => 'alert alert-success',
            'error'       => 'alert alert-error',
        ));

        return new $flash;
    }
);

$di->set(
    'flashSession',
    function () {
        $flashSession = new \Phalcon\Flash\Session( array(
            'warning'     => 'alert alert-warning',
            'notice'      => 'alert alert-info',
            'success'     => 'alert alert-success',
            'error'       => 'alert alert-error',
        ));

        return new $flashSession;
    }
);

$di->setShared('url', function () {
    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri('/');

    return $url;
});

$di->set('request', function(){

    return new Phalcon\Http\Request();
}, true);

$di->set('response', function(){

    return new Phalcon\Http\Response();
}, true);

$di->setShared('view', function () {
    $view = new Phalcon\Mvc\View();
    $view->setViewsDir(__DIR__ . '/../Views/');

    return $view;
});

$di->setShared('security', function () {
    $security = new Phalcon\Security();
    $security->setWorkFactor(12);
    $security->setDefaultHash(Phalcon\Security::CRYPT_BLOWFISH_Y); // choose default hash

    return $security;
});

$di->set('crypt', function () {
    $crypt = new Phalcon\Crypt();
    $crypt->setKey('saltsaltsaltSALTSALTSALT');

    return $crypt;
});

$di->set('router',      'Phalcon\Mvc\Router');
$di->set('dispatcher',  'Phalcon\Mvc\Dispatcher');
$di->set('escaper',     'Phalcon\Escaper');
$di->set('filter',      'Phalcon\Filter' );
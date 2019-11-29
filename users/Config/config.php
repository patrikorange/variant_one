<?php



return new \Phalcon\Config([
    'database' => [
        'dbname' => 'db/backend.sqlite3',
        'adapter' => 'Sqlite',
    ],

    'application' => [
        'controllersDir'    =>  __DIR__ .'/../Controllers/',
        'modelsDir'         =>  __DIR__ .'/../Models/',
        'migrationsDir'     =>  __DIR__ .'/../Migrations/',
        'viewsDir'          => __DIR__  .'/../Views/',
        'baseUri'           => '/',
    ]
]);
<?php

//namespace Middleware;

use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

class ResponseMiddleware implements MiddlewareInterface
{
    public function call(Micro $application)
    {
        $payload = [
            "jsonrpc"   => "2.0",
            'result'    => $application->getReturnedValue(),
            "id"        => $application->router->id
        ];

        $application->response->setJsonContent($payload);
        $application->response->send();

        return true;
    }
}
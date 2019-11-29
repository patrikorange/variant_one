<?php


//namespace Middleware;


use Phalcon\Events\Event;
use Phalcon\Exception;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;


class RequestMiddleware implements MiddlewareInterface
{
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $payload = json_decode($application->getSharedService('request')->getRawBody(), true);

        if (!is_array($payload)) {
            throw new Exception('Parse error', -32700);
        }

        if(
            empty($payload) ||

            empty($payload['jsonrpc'])     ||
            $payload['jsonrpc'] !== '2.0'  ||

            empty($payload['method'])      ||
            !is_string($payload['method']) ||

            empty($payload['params'])      ||
            !is_array($payload['params'])  ||

            empty($payload['id'])          ||
            (!is_int($payload['id']))

        )
        {
            throw new Exception('Invalid request', -32600);
        }

        $application->router->id = $payload['id'];

        list($controllerName, $actionName) = explode('.', $payload['method']);

        $controllerName = sprintf("%sController", ucfirst($controllerName));

        if(!class_exists($controllerName)) {
            throw new \Exception('The method does not exist / is not available.', -32601);
        }

        $controller = new $controllerName;

        if(!method_exists($controller, $actionName)) {
            throw new Exception('The method does not exist / is not available.', -32601);
        }

        $application->router->add(
            '/',     [
                'controller' => $controllerName,
                'action'     => $actionName,
            ]
        );

        // DISPATCH to controller and method
        $application->post("/", [$controller, $actionName]);

        return true;
    }

    public function call(Micro $application) {

        return true;
    }
}
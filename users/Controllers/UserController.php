<?php

//namespace User\Controllers;

use Phalcon\Mvc\Controller;


class UserController extends Controller
{
    public function index()
    {
        return "index action";
    }

    public function login()
    {
        $data = json_decode($this->request->getRawBody(), true);

        $user = Users::findFirst(
            [
                "username = :username: AND password = :password:",
                'bind' => [
                    'username'    => $data['params']['username'],
                    'password'    => $data['params']['password'],
                ]
            ]
        );

        if ($user !== false) {
            return "OK";
        } else {
            throw new \Phalcon\Exception('Authorization error', 32001);
        }
    }
}
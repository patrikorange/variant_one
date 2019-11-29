<?php

namespace  Controllers;

use Phalcon\Mvc\Controller;
use Forms\LoginForm;
use Phalcon\Mvc\View;

class IndexController extends Controller {


    public function indexAction()
    {
        $form = new LoginForm();

        $this->view->setVar('form', $form);

        return $this->view->render('index', 'index');
    }

    public function login()
    {
        $form = new LoginForm();

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost()) == false) {
                foreach ($form->getMessages() as $message) {
                    $this->flashSession->error($message->getMessage());
                }
            } else {
                $content =  json_encode(
                    [
                        'jsonrpc' => '2.0',
                        'method' => 'user.login',
                        'params' => [
                            'username' => $this->request->getPost('username'),
                            'password' => $this->request->getPost('password'),
                        ],
                        'id' => mt_rand(),
                    ]
                );

                $context = stream_context_create(['http' =>
                    [
                        'method' => 'POST',
                        'header' => 'Content-Type: application/json',
                        'content' => $content,
                    ],
                ]);

                ### http://users
                $response = file_get_contents('http://users', false, $context);

                $data = json_decode($response, true);

                if(empty($data)) {
                    $this->flashSession->error('что-то пошло не так');
                }

                if(!empty($data['error'])) {
                    $this->flashSession->error('неверный логин или пароль');
                }

                if (!empty($data['result']) && $data['result'] == "OK")  {
                    $this->flashSession->success('успешная авторизация');
                }
            }
        }

        return $this->response->redirect('/');

    }

};
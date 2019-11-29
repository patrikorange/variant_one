<?php

namespace app\Forms;

namespace Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;


class LoginForm extends Form
{
    public function initialize()
    {
        // Email
        $username = new Text('username', [
            'placeholder' => 'Username'
        ]);

        $username->addValidators([
            new PresenceOf([
                'message' => 'The username is required'
            ])
        ]);

        $this->add($username);

        // Password
        $password = new Password('password', [
            'placeholder' => 'Password'
        ]);

        $password->addValidator(new PresenceOf([
            'message' => 'The password is required'
        ]));

        $password->clear();

        $this->add($password);

        //CSRF
        $csrf = new Hidden($this->security->getTokenKey());

        $csrf->setDefault($this->security->getToken())
            ->addValidator(new Identical([
                'accepted'   => $this->security->checkToken(),
                'message' => 'CSRF forgery detected!'
            ]));
        $this->add($csrf);

        $this->add(new Submit('Submit'));
    }

    public function getCsrfTokenName()
    {
        if (empty($this->_csrf)) {
            $this->_csrf = $this->security->getTokenKey();
        }

        return $this->_csrf;
    }
}

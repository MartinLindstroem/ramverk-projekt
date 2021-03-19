<?php

namespace Marty\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                // "legend" => "Create User",
            ],
            [
                "email" => [
                    "type"        => "text",
                ],
                "username" => [
                    "type"        => "text",
                ],
                        
                "password" => [
                    "type"        => "password",
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Register",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $email         = $this->form->value("email");
        $username      = $this->form->value("username");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain ) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $hashedEmail = md5(strtolower(trim($email)));
        $avatar = "https://www.gravatar.com/avatar/" . $hashedEmail . "?s=40";

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->email = $email;
        $user->username = $username;
        $user->setPassword($password);
        $user->avatar = $avatar;
        $user->created = date("Y-m-d H:i:s");
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }
}

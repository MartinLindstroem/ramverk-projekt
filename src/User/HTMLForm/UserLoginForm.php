<?php

namespace Marty\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "User Login"
            ],
            [
                "username" => [
                    "type"        => "text",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],
                        
                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $username      = $this->form->value("username");
        $password      = $this->form->value("password");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $res = $user->verifyPassword($username, $password);
    
        if (!$res) {
           $this->form->rememberValues();
           $this->form->addOutput("User or password did not match.");
           return false;
        }

        $user->active = date("Y-m-d H:i:s");
        $user->save();

        $this->form->addOutput("User logged in.");
        $this->di->session->set("user", $username);
        return true;
    }
}

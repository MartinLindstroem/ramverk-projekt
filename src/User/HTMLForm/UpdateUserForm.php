<?php

namespace Marty\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\User\User;

/**
 * Example of FormModel implementation.
 */
class UpdateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $username)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($username);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update User",
            ],
            [
                "username" => [
                    "type"        => "text",
                    "readonly"    => true,
                    "value"       => $user->username,
                ],
                "email" => [
                    "type"        => "text",
                    "value"       => $user->email,
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
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Question
     */
    public function getItemDetails($username) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("username", $username);
        return $user;
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
        $user->find("username", $this->form->value("username"));
        $user->email = $email;
        $user->setPassword($password);
        $user->avatar = $avatar;
        $user->updated = date("Y-m-d H:i:s");
        $user->save();

        $this->form->addOutput("User was created.");
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/profile/{$this->form->value('username')}")->send();
        //$this->di->get("response")->redirect("question/update/{$question->id}");
    }
}

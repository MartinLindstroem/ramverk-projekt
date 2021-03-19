<?php

namespace Marty\Tag2Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Tag2Question\Tag2Question;

/**
 * Form to delete an item.
 */
class DeleteForm extends FormModel
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
                "legend" => "Delete an item",
            ],
            [
                "select" => [
                    "type"        => "select",
                    "label"       => "Select item to delete:",
                    "options"     => $this->getAllItems(),
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Delete item",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Get all items as array suitable for display in select option dropdown.
     *
     * @return array with key value of all items.
     */
    protected function getAllItems() : array
    {
        $tag2Question = new Tag2Question();
        $tag2Question->setDb($this->di->get("dbqb"));

        $tag2Questions = ["-1" => "Select an item..."];
        foreach ($tag2Question->findAll() as $obj) {
            $tag2Questions[$obj->id] = "{$obj->column1} ({$obj->id})";
        }

        return $tag2Questions;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $tag2Question = new Tag2Question();
        $tag2Question->setDb($this->di->get("dbqb"));
        $tag2Question->find("id", $this->form->value("select"));
        $tag2Question->delete();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("tag2Question")->send();
    }



    // /**
    //  * Callback what to do if the form was unsuccessfully submitted, this
    //  * happen when the submit callback method returns false or if validation
    //  * fails. This method can/should be implemented by the subclass for a
    //  * different behaviour.
    //  */
    // public function callbackFail()
    // {
    //     $this->di->get("response")->redirectSelf()->send();
    // }
}

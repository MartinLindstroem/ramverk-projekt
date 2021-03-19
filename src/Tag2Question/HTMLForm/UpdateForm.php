<?php

namespace Marty\Tag2Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Tag2Question\Tag2Question;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the id to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $id to update
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $tag2Question = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $tag2Question->id,
                ],

                "column1" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $tag2Question->column1,
                ],

                "column2" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $tag2Question->column2,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
                ],
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * 
     * @return Tag2Question
     */
    public function getItemDetails($id) : object
    {
        $tag2Question = new Tag2Question();
        $tag2Question->setDb($this->di->get("dbqb"));
        $tag2Question->find("id", $id);
        return $tag2Question;
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
        $tag2Question->find("id", $this->form->value("id"));
        $tag2Question->column1 = $this->form->value("column1");
        $tag2Question->column2 = $this->form->value("column2");
        $tag2Question->save();
        return true;
    }



    // /**
    //  * Callback what to do if the form was successfully submitted, this
    //  * happen when the submit callback method returns true. This method
    //  * can/should be implemented by the subclass for a different behaviour.
    //  */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("tag2Question")->send();
    //     //$this->di->get("response")->redirect("tag2Question/update/{$tag2Question->id}");
    // }



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

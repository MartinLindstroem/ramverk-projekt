<?php

namespace Marty\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Answer\Answer;

/**
 * Form to delete an item.
 */
class DeleteForm extends FormModel
{

    protected $question_id;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $answer = $this->getItem($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete an item",
                "escape-values" => false,
            ],
            [
                // "select" => [
                //     "type"        => "select",
                //     "label"       => "Select item to delete:",
                //     "options"     => $this->getAllItems(),
                // ],

                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $answer->id,
                ],

                "content" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $answer->content,
                ],
                    "submit" => [
                    "type" => "submit",
                    "value" => "Delete answer",
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
    protected function getItem($id) : object
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $id);
        $this->question_id = $answer->question_id;

        // $answers = ["-1" => "Select an item..."];
        // foreach ($answer->findAll() as $obj) {
        //     $answers[$obj->id] = "{$obj->column1} ({$obj->id})";
        // }

        return $answer;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->find("id", $this->form->value("id"));
        $answer->delete();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("questions/question/{$this->question_id}")->send();
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

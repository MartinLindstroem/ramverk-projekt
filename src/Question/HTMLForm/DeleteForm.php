<?php

namespace Marty\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Question\Question;

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
        $question = $this->getItem($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Delete an item",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $question->id,
                ],

                "content" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $question->content,
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
    protected function getItem($id) : object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $id);
        $this->question_id = $question->id;

        // $questions = ["-1" => "Select an item..."];
        // foreach ($question->findAllWhere("posted_by = ?", $this->di->session->get("user")) as $obj) {
        //     $questions[$obj->id] = "{$obj->title} ({$obj->id})";
        // }

        return $question;
    }


    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->find("id", $this->form->value("id"));
        $question->delete();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("questions")->send();
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

<?php

namespace Marty\Comment\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Comment\Comment;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
{

    protected $id;
    protected $type;
    // protected $formId;
    // protected $question_id;
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id, $type, $formId)
    {
        $this->id = $id;
        $this->type = $type;
        // $this->question_id = $questionId;
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__ . $formId,
                // "legend" => "Details of the item",
                "use_fieldset" => false,
                "use_label" => false,
            ],
            [
                "content" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "placeholder" => "comment",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Comment",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $comment = new Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->content = $this->form->value("content");
        $comment->posted_by = $this->di->session->get("user");
        $comment->posted = date("Y-m-d H:i:s");

        switch ($this->type) {
            case 'question':
                $comment->question_id = $this->id;
                break;
            case 'answer':
                $comment->answer_id = $this->id;
                break;
        }
        $comment->save();
        return true;
    }



    /**
     * Callback what to do if the form was successfully submitted, this
     * happen when the submit callback method returns true. This method
     * can/should be implemented by the subclass for a different behaviour.
     */
    // public function callbackSuccess()
    // {
    //     $this->di->get("response")->redirect("questions/question/{$this->question_id}")->send();
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

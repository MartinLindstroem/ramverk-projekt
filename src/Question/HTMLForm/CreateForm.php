<?php

namespace Marty\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Marty\Question\Question;

/**
 * Form to create an item.
 */
class CreateForm extends FormModel
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
                "legend" => "Details of the item",
                "escape-values" => false,
            ],
            [
                "title" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                ],
                        
                "content" => [
                    "type" => "textarea",
                    "validation" => ["not_empty"],
                ],

                "tags" => [
                    "type" => "text",
                    "placeholder" => "ex: html php anax",
                    "validation" => ["not_empty"],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create item",
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
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title  = $this->form->value("title");
        $question->content = $this->form->value("content");
        $question->posted_by = $this->di->session->get("user");
        $question->posted = date("Y-m-d H:i:s");
        $question->save();

        $tags = explode(" ", $this->form->value("tags"));

        foreach ($tags as $tagName) {
            $tag = new \Marty\Tag\Tag();
            $tag2Question = new \Marty\Tag2Question\Tag2Question();
            $tag->setDb($this->di->get("dbqb"));
            $tag2Question->setDb($this->di->get("dbqb"));

            $tag2Question->tag_name = $tagName;
            $tag2Question->question_id = $question->id;
            $tag2Question->save();

            if ($tag->find("tag_name", $tagName)->tag_name == null) {
                $tag->tag_name = $tagName;
                $tag->save();
            }
        }

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

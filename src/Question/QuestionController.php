<?php

namespace Marty\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Marty\Question\HTMLForm\CreateForm;
use Marty\Question\HTMLForm\EditForm;
use Marty\Question\HTMLForm\DeleteForm;
use Marty\Question\HTMLForm\UpdateForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Show all items.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $user = $this->di->session->get("user");

        // var_dump($this->di->session->get("user"));
        $items = $question->findAll();
        usort($items, function($a, $b) {return strcmp(strtotime($b->posted), strtotime($a->posted));}); 

        $page->add("question/crud/view-all", [
            "items" => $items,
            "user" => $user
        ]);

        return $page->render([
            "title" => "Questions",
        ]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return object as a response object
     */
    public function createAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateForm($this->di);
        $form->check();

        $page->add("question/crud/create", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Create a item",
        ]);
    }



    /**
     * Handler with form to delete an item.
     *
     * @return object as a response object
     */
    public function deleteAction($id) : object
    {
        $page = $this->di->get("page");
        $form = new DeleteForm($this->di, $id);
        $form->check();

        $page->add("question/crud/delete", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Delete an item",
        ]);
    }



    /**
     * Handler with form to update an item.
     *
     * @param int $id the id to update.
     *
     * @return object as a response object
     */
    public function updateAction(int $id) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateForm($this->di, $id);
        $form->check();

        $page->add("question/crud/update", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update an item",
        ]);
    }


    public function questionAction(int $id) : object
    {
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->find("id", $id);
        $title = $quest->title;

        $answer = new \Marty\Answer\Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("question_id = ?", $id);

        $comment = new \Marty\Comment\Comment();
        $comment->setDb($this->di->get("dbqb"));
        $comments = $comment->findAllWhere("question_id = ?", $id);

        $formId = 0;

        $questionCommentForm = new \Marty\Comment\HTMLForm\CreateForm($this->di, $id, "question", $formId);
        $questionCommentForm->check();

        $form = new \Marty\Answer\HTMLForm\CreateForm($this->di, $id);
        $form->check();

        $user = $this->di->session->get("user");

        $textfilter = new \Anax\TextFilter\TextFilter;

        // var_dump($answers);

        $page->add("question/crud/view-question", [
            "item" => $question->find("id", $id),
            "textfilter" => $textfilter,
            "form" => $form->getHTML(),
            "question" => $quest,
            "answers" => $answers,
            "user" => $user,
            "questionCommentForm" => $questionCommentForm->getHTML(),
            "comment" => $comment,
            "comments" => $comments,
            "formId" => $formId,
            // "questionId" => $id,
            "di" => $this->di,
        ]);

        return $page->render([
            "title" => $title,
        ]);
    }




    /**
     * Handler with form to update an item.
     *
     * @param string $tag the tag to search for.
     *
     * @return object as a response object
     */
    public function taggedAction(string $tag) : object
    {
        $page = $this->di->get("page");

        $tags = new \Marty\Tag2Question\Tag2Question();
        $tags->setDb($this->di->get("dbqb"));

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));

        $id = $tags->findAllWhere("tag_name = ?", $tag);
        $questions = [];

        foreach ($id as $item) {
            $tagQuestion = new Question();
            $tagQuestion->setDb($this->di->get("dbqb"));
            $taggedQuestion = $tagQuestion->findById($item->question_id);
            array_push($questions, $taggedQuestion);
        };

        $page->add("tag/view-tagged-questions", [
            "questions" => $questions,
            "tag" => $tag,
        ]);

        return $page->render([
            "title" => "{$tag} questions",
        ]);
    }
}

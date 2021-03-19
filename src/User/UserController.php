<?php

namespace Marty\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Marty\User\HTMLForm\UserLoginForm;
use Marty\User\HTMLForm\CreateUserForm;
use Marty\User\HTMLForm\UpdateUserForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");

        $page->add("anax/v2/article/default", [
            "content" => "An index page",
        ]);

        return $page->render([
            "title" => "A index page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function registerAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        // $page->add("anax/v2/article/default", [
        //     "content" => $form->getHTML(),
        // ]);

        $page->add("user/register", [
            "form" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
        ]);
    }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function updateAction($username) : object
    {
        $page = $this->di->get("page");
        $form = new UpdateUserForm($this->di, $username);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update profile",
        ]);
    }



    public function profileAction($username) : object
    {
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));

        $question = new \Marty\Question\Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("posted_by = ?", $username);

        $answer = new \Marty\Answer\answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("posted_by = ?", $username);
        

        $page->add("user/user", [
            "user" => $user->find("username", $username),
            "questions" => $questions,
            "answers" => $answers,
            "di" => $this->di,
            // "questions" => $questions->findAllWhere("posted_by = ?", $username),
        ]);

        return $page->render([
            "title" => "User {$username}",
        ]);
    }



    public function logoutActionGet() : object
    {
        $this->di->session->set("user", null);
        $this->di->get("response")->redirect("")->send();
    }
}

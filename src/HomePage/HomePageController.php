<?php

namespace Marty\HomePage;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $di if implementing the interface
 * ContainerInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class HomePageController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        // Use to initialise member variables.
        $this->db = "active";
    }



    /**
     * Show all tags.
     *
     * @return object as a response object
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $question = new \Marty\Question\Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $latestQuestions = array_slice($questions, -3, 3);
        usort($latestQuestions, function($a, $b) {return strcmp(strtotime($b->posted), strtotime($a->posted));}); 

        $user = new \Marty\User\User();
        $user->setDb($this->di->get("dbqb"));
        $users = $user->findAll();
        $activeUsers = [];

        foreach ($users as $user) {
            $arr = [$user->username => $user->active];
            $activeUsers += $arr;
        }
        arsort($activeUsers);

        $tag = new \Marty\Tag2Question\Tag2Question();
        $tag->setDb($this->di->get("dbqb"));
        $allTags = $tag->findAll();
        $tags = [];

        foreach ($allTags as $tag) {
            array_push($tags, $tag->tag_name);
        }

        $frequentTags = array_count_values($tags);
        arsort($frequentTags);

        $page->add("homepage/index", [
            "latestQuestions" => $latestQuestions,
            "frequentTags" => $frequentTags,
            "activeUsers" => $activeUsers,
            
        ]);

        return $page->render([
            "title" => "A collection of items",
        ]);
    }
}

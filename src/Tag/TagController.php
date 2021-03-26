<?php

namespace Marty\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Marty\Tag\HTMLForm\CreateForm;
use Marty\Tag\HTMLForm\EditForm;
use Marty\Tag\HTMLForm\DeleteForm;
use Marty\Tag\HTMLForm\UpdateForm;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;


    /**
     * Show all tags.
     *
     * @return object as a response object
     */
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));

        $page->add("tag/view-all", [
            "items" => $tag->findAll(),
        ]);

        return $page->render([
            "title" => "Tags",
        ]);
    }
}

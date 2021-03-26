<?php

namespace Marty\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class AboutControllerTest extends TestCase
{
    protected $di;


    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $controller = new \Marty\About\AboutPageController();
        $controller->setDi($this->di);
        $res = $controller->indexAction();
        $body = $res->getBody();
        $this->assertContains("About", $body);
    }
}

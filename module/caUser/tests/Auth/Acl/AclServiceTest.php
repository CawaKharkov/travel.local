<?php

namespace caUserTest\Auth\Acl;

use caUser\Auth\Acl\AclService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as TestCase;
use Mockery;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AclServiceTest
 *
 * @author Cawa
 */
class AclServiceTest extends TestCase
{
    
    protected $acl;
    protected $request;
    protected $router;
    protected $event;



    public function setUp()
    {
        $this->setApplicationConfig(
            require __DIR__ . '/../../../../../config/application.config.php'
        );
        $this->sm = $serviceManager = $this->getApplicationServiceLocator();
        $this->sm->setAllowOverride(true);
        
        $this->request    = new Request();
        $this->event      = new MvcEvent();

        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);

        $this->router = $router;

        $this->request->setMethod(Request::METHOD_GET);
        $this->request->setUri('/');

        $this->acl = new AclService();
        parent::setUp();
    }
    
    
    public function testCanAccess()
    {
        $this->assertNotEmpty($this->request);
        $this->assertNotEmpty($this->router);
        $this->assertNotEmpty($this->acl);
        $this->assertTrue($this->acl->canAccess($this->router,  $this->request));
    }

}


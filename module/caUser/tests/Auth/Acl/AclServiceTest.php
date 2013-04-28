<?php

namespace caUserTest\Auth\Acl;

use caUser\Auth\Acl\AclService;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as TestCase;
use Mockery;
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
    
    protected $alc;
    
    public function setUp()
    {
        $this->setApplicationConfig(
            require __DIR__ . '/../../../../../config/application.config.php'
        );
        $this->sm = $serviceManager = $this->getApplicationServiceLocator();
        $this->sm->setAllowOverride(true);
        //$this->alc = new AclService;
        parent::setUp();
    }
    
    
    public function testCanAccess()
    {
        $this->assertEquals(0, 0);
    }

}


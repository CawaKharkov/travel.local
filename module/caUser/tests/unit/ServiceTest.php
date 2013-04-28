<?php
/**
 * namespace
 */
namespace caUser\tests\unit;
//use DoctrineORMModuleTest\Framework\TestCase;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as TestCase;
use Mockery;

class ServiceTest extends TestCase
{
    protected $sm;
    public function setUp()
    {
        $this->setApplicationConfig(
              require __DIR__ . '/../../../../config/application.config.php'
        );
        $this->sm = $serviceManager = $this->getApplicationServiceLocator();
        $this->sm->setAllowOverride(true);
        parent::setUp();
    }

    public function testCanGetRepository()
    {
        //$repository = new \caUser\Repository\UserRepository();
        //$service = new \caUser\Service\UserService();
        //$this->assertEquals($repository, $service->getRepository());
    }

}


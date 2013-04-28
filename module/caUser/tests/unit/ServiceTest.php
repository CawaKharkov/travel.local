<?php
/**
 * namespace
 */
namespace caUserTests\Unit;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as TestCase;
use Mockery;

/**
 * Class ServiceTest
 * @package caUserTests\Unit
 */
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

    /**
     * Test get User Repository from User Service
     */
    public function testCanGetRepository()
    {
        //$service = new \caUser\Service\UserService($this->sm);
        //$repository = $this->getMockBuilder('\caUser\Repository\UserRepository')->disableOriginalConstructor()->getMock();
        //$service = $this->getMockBuilder('\caUser\Repository\UserSerivce')->enableOriginalConstructor()->getMock();
        //$service = $this->getMock('\caUser\Repository\UserSerivce',['getRepository'],[],'',false)->expects($this->once())->method('getRepository');
        //var_dump($service);
        //$service->expects($this->once())->method('getRepository');

        //var_dump($service);
        //$this->assertInstanceOf('\caUser\Repository\UserRepository', $service->getRepository());
    }

}


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
        $service = Mockery::mock('\caUser\Service\UserService');
        $repository = Mockery::mock('\caUser\Repository\UserRepository');
        $service->shouldReceive('getRepository')->andReturn($repository);
        $this->assertEquals($repository, $service->getRepository());
    }

    /**
     * Second test get User Repository
     */
    public function testCanGetRepositoryInService()
    {
        $repository = Mockery::mock('\caUser\Repository\UserRepository');
        $this->assertInstanceOf('\caUser\Repository\UserRepository', $repository);
    }

    public function testGetCurrentUser()
    {
        $authenticationService = $this->sm->get('Zend\Authentication\AuthenticationService');
        $authserv = $this->sm->get('doctrine.authenticationservice.orm_default');
        $this->assertEquals($authenticationService, $authserv);
    }

}


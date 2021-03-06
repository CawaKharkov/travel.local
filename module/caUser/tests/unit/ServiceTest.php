<?php
/**
 * namespace
 */
namespace caUserTests\Unit;
use Zend\Crypt\Password\Bcrypt;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase as TestCase;
use caUser\Service\UserService;
use caUser\Entity\User;
use Mockery;
use caUserTest\Bootstrap;

/**
 * Class ServiceTest
 * @package caUserTests\Unit
 */
class ServiceTest extends TestCase
{
    protected $sm;
    protected $em;

    public function setUp()
    {
        $this->setApplicationConfig(
              require __DIR__ . '/../../../../config/application.config.php'
        );
        $this->sm = $this->getApplicationServiceLocator();
        $this->sm->setAllowOverride(true);
        $this->em = Bootstrap::getSqlLiteEm();
        parent::setUp();
    }

    public function testCanInstanceUserService()
    {
        $service = new UserService($this->sm);
        $this->assertInstanceOf('caUser\Service\UserService', $service);
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

    /**
     * Check credencial
     * @return bool
     */
    public function testCheckCredencial()
    {
        $passwordGiven = "test";
        $bcrypt = new Bcrypt();
        $passwordHash = $bcrypt->create($passwordGiven);
        $this->assertTrue($bcrypt->verify($passwordGiven, $passwordHash));
    }

    public function testExitUser()
    {
        $authService = $this->sm->get('Zend\Authentication\AuthenticationService');
        $this->assertNotEmpty($authService);
        $sessionAuth = $authService->getStorage()->clear();
        $this->assertEmpty($sessionAuth);

    }

}


<?php
/**
 * namespace
 */
namespace caUser\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\Password\Bcrypt;

/**
 * Class UserService
 * @package caUser\Service
 */
class UserService implements ServiceLocatorAwareInterface
{

    private $serviceLocator;
    private $em;

    /**
     *  Set service locator in counstruct
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get EntityManager
     * @return \Doctrine\ORM\EntityManager;
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('\caUser\Entity\User');
    }

    /**
     * Check password (bcript algoritm)
     * @param string $passwordGiven
     * @param string $hashpass
     * @return bool
     */
    static public function checkCredencial($passwordGiven, $hashpass)
    {
        $bcript = new Bcrypt();
        return $bcript->verify($passwordGiven, $hashpass);
    }

    /**
     * Auth User
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate($login, $password)
    {
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        $adapter = $authService->getAdapter();
        $adapter->setIdentityValue($login);
        $adapter->setCredentialValue($password);
        $authResult = $authService->authenticate();

        if ($authResult->isValid()) {
            $identity = $authResult->getIdentity();
            $authService->getStorage()->write($identity);
            $pluginManager = $this->getServiceLocator()->get('Zend\Mvc\Controller\PluginManager');
            $redirectPlugin = $pluginManager->get('redirect');
            return $redirectPlugin->toRoute('Cabinet');
        } else {
            return false;
        }
    }

    /**
     * Get current user
     * @return \caUser\Entity\User
     */
    public function getCurrentUser()
    {
        $authenticationService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        return $authenticationService->getIdentity();

    }

    /**
     * @param string $email
     * @return \caUser\Entity\User
     */
    public function getUserbyEmail($email)
    {
        $user = $this->getEntityManager()->getRepository('\caUser\Entity\User')->findOneBy(['email' => $email]);
        return $user;
    }

    /**
     * Registration User
     * @param \caUser\Entity\User $user
     * @return \caUser\Entity\User
     */
    public function registrationUser(\caUser\Entity\User $user)
    {
        return $this->getRepository()->save($user);
    }
}
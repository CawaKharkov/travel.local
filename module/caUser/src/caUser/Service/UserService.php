<?php
/**
 * namespace
 */
namespace caUser\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\Password\Bcrypt;

class UserService implements ServiceLocatorAwareInterface
{

    private $serviceLocator;

    /**
     *  Set service locator in counstruct
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
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

    /**
     * Check password (bcript algoritm)
     * @param $passwordGiven
     * @param $hashpass
     * @return bool
     */
    static public function checkCredencial($passwordGiven, $hashpass)
    {
        $bcript = new Bcrypt();
        return $bcript->verify($passwordGiven, $hashpass);
    }

    /**
     * Auth User
     * @param $login
     * @param $password
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
}
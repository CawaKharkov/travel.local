<?php
/**
 * namespace
 */
namespace caUser\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

/**
 * Class UserService
 * @package caUser\Service
 */
class UserService implements ServiceLocatorAwareInterface
{

    private $serviceLocator;
    private $em;
    private $causerConfig;

    /**
     *  Set service locator in counstruct
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function __construct(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->causerConfig = $this->serviceLocator->get('config')['causer'];
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

    /**
     * Get User Repository
     * @return \Doctrine\ORM\EntityRepository
     */
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
            return $redirectPlugin->toRoute($this->causerConfig['options']['redirect']['route']);
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

    /**
     * Exit user
     * @return mixed
     */
    public function exitUser()
    {
        $authService = $this->serviceLocator->get('Zend\Authentication\AuthenticationService');
        $authService->getStorage()->clear();
        $pluginManager = $this->getServiceLocator()->get('Zend\Mvc\Controller\PluginManager');
        $redirectPlugin = $pluginManager->get('redirect');
        return $redirectPlugin->toRoute('cuUser', ['action' => 'login']);
    }

    /**
     * Delete User
     * @param \caUser\Entity\User $user
     * @return \caUser\Service\UserService
     */
    public function deleteUser(\caUser\Entity\User $user)
    {
        $this->getRepository()->delete($user);
        return $this;
    }

    /**
     * Get user by id
     * @param integer $id
     * @return \caUser\Entity\User
     */
    public function getUserById($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Restore password for user
     * @return \caUser\Entity\User
     * @throw \Exception
     */
    public function restorePassword($email)
    {

        $user = $this->getUserbyEmail($email);
        if ($user)
        {
            $bcrypt = new Bcrypt();

            //generate password for cript again
            $values = array_merge(range(65, 90), range(97, 122), range(48, 57));
            $max = count($values) - 1;
            $str = chr(mt_rand(97, 122));
            $length = $this->causerConfig['password_restore']['password_length'];
            for ($i = 1; $i < $length; $i++) {
                $str .= chr($values[mt_rand(0, $max)]);
            }
            //crypt password and set to entity
            $password = $bcrypt->create($str);
            $user->setPassword($password);
            $this->getRepository()->save($user);
            //send new password to email
            $message = new Message();
            $transport = new Smtp();
            $transportOptions = new SmtpOptions($this->causerConfig['password_restore']['mail']['smtp']);
            $message->setBody('Your new password: ' . $str);
            $message->addFrom($this->causerConfig['password_restore']['mail']['options']['sender']);
            $message->addTo($email);
            $message->setSubject($this->causerConfig['password_restore']['mail']['options']['subject']);
            $transport->setOptions($transportOptions);
            $transport->send($message);

            return $user;
        } else
        {
            throw new \Exception('Email not found');
        }

    }

    /**
     * @param string $oldpassword
     * @param string $newpassword
     */
    public function changePassword($oldpassword, $newpassword)
    {
        $user = $this->getCurrentUser();
        $bcrypt = new Bcrypt();
        if($bcrypt->verify($oldpassword, $user->getPassword()))
        {
            $user->setPassword($bcrypt->create($newpassword));
            $this->getRepository()->save($user);
        } else
        {
            throw new \Exception('Incorrect old password');
        }
    }
}
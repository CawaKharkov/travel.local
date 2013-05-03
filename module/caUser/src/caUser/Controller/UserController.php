<?php
/**
 * namespace
*/
namespace caUser\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\ViewModel;
use ZendOpenId\OpenId;
use caUser\Service\UserService as Service;
use caUser\Form\RegistrationForm;
use caUser\Form\LoginForm;
use caUser\Form\RegistrationValidator;
use caUser\Form\LoginValidator;
use caUser\Entity\User;
use caUser\Form\RestorePasswordForm;
use caUser\Form\RestorePasswordValidator;

/**
 * Class UserController
 * @package caUser\Controller
 */
class UserController extends AbstractController
{
    /**
     * Login Action
     * @redirect Cabinet
     * @return ViewModel
     */
    public function loginAction()
    {
        $service = new Service($this->getServiceLocator());
        $vm = new ViewModel();

        if(!$service->getCurrentUser()){
            $form = new LoginForm();
            $request = $this->getRequest();
            $form->get('submit')->setValue('Enter');

            if($request->isPost()) {
                $validator = new LoginValidator();
                $form->setInputFilter($validator->getInputFilter());
                $form->setData($request->getPost());

                if ($form->isValid()) {
                    $data = $form->getData();

                    if(!$service->authenticate($data['email'], $data['password']) )
                    {
                        $error = [
                            'password' => ['Invalid email or password']
                        ];

                        $form->setMessages($error);
                    } else
                    {
                       return  $this->redirect()->toRoute('Cabinet');
                    }
                }
            }

            $vm->setVariable('form', $form);
        } else {
            return  $this->redirect()->toRoute('Cabinet');
        }
        return $vm;
    }

    /**
     * Cabinet action
     * @return \Zend\Http\Response|ViewModel
     */
    public function cabinetAction()
    {
        $service = new Service($this->getServiceLocator());
        if ($service->getCurrentUser()) {
            return new ViewModel(['user' => $service->getCurrentUser()]);
        } else {
            return $this->redirect()->toRoute('cuUser', ['action' => 'login']);
        }

    }

    /**
     * Registration action
     * @return \Zend\View\Model\ViewModel
     */
    public function registrationAction()
    {
        $vm = new ViewModel();
        $service = new Service($this->getServiceLocator());
        $form = new RegistrationForm();
        $form->get('submit')->setValue('registration');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $validator = new RegistrationValidator();
            $form->setInputFilter($validator->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                if ($data['password'] != $data['repeatpassword'])
                {
                   $error = [
                       'repeatpassword' => ['passwords don\'t coincide']
                   ];

                   $form->setMessages($error);
                } elseif(!$service->getUserbyEmail($data['email'])) {
                    $bcript = new Bcrypt();
                    $password = $bcript->create($data['password']);
                    $arr = [
                        'email' => $data['email'],
                        'username' => $data['username'],
                        'password' => $password
                    ];
                    $user = new User($arr);
                    $service->registrationUser($user);
                    $service->authenticate($data['email'], $data['password']);
                } else {
                    $error = [
                        'email' => ['this email exists']
                    ];

                    $form->setMessages($error);
                }
            }
        }
        $vm->setVariable('form', $form);
        return $vm;
    }

    public function exitAction()
    {
        $service = new Service($this->getServiceLocator());
        $service->exitUser();

    }

    public function restorepasswordAction()
    {
        $vm = new ViewModel();
        $form = new RestorePasswordForm();
        $form->get('submit')->setValue('restore');
        $request = $this->getRequest();

        if($request->isPost())
        {
            $validator = new RestorePasswordValidator();
            $form->setInputFilter($validator->getInputFilter());
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = new Service($this->getServiceLocator());
                try {
                    $service->restorePassword($form->getData()['email']);
                    $message = [
                        'email' => ['New password send to your email ' . $form->getData()['email']]
                    ];
                    $form->setMessages($message);
                } catch(\Exception $e)
                {
                    $message = [
                        'email' => [$e->getMessage()]
                    ];
                    $form->setMessages($message);
                }
            } else

            {
                $message = [
                    'email' => ['Invalid email or short chars']
                ];
                $form->setMessages($message);
            }
        }
        $vm->setVariable('form', $form);
        return $vm;
    }
}
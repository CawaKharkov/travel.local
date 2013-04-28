<?php
/**
 * namespace
*/
namespace caUser\Controller;

use Zend\Crypt\Password\Bcrypt;
use Zend\View\Model\ViewModel;
use caUser\Service\UserService as Service;
use caUser\Form\RegistrationForm;
use caUser\Form\RegistrationValidator;
use caUser\Entity\User;

/**
 * Class UserController
 * @package caUser\Controller
 */
class UserController extends AbstractController
{
    public function loginAction()
    {
        $service = new Service($this->getServiceLocator());
        $service->getCurrentUser() ? $this->redirect()->toRoute('Cabinet') : "";
       // var_dump($service->authenticate('test', 'test'));
    }

    public function cabinetAction()
    {
        $service = new Service($this->getServiceLocator());
        return new ViewModel(['user' => $service->getCurrentUser()]);
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
}
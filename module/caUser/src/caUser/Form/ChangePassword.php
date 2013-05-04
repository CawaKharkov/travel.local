<?php
/**
 * namespace
 */
namespace caUser\Form;

use Zend\Form\Form;

/**
 * Class ChangePassword
 * @package caUser\Form
 */
class ChangePassword extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('ChangePasswordForm');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'oldpassword',
            'type' => 'Password',
            'options' => array(
                'label' => 'Old Password',
            ),
        ));
        $this->add(array(
            'name' => 'newpassword',
            'type' => 'Password',
            'options' => array(
                'label' => 'New Password',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
                'class' => 'btn-primary'
            ),
        ));
    }
}
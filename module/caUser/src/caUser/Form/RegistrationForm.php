<?php
/**
 * namespace
 */
namespace caUser\Form;
use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('RegistrationForm');
        $this->setAttribute('method', 'post');

        $dirdata = './public';

        $captchaImage = new CaptchaImage( array(
                'font' => $dirdata . '/font/arial.ttf',
                'width' => 200,
                'height' => 50,
                'dotNoiseLevel' => 40,
                'lineNoiseLevel' => 3,
                'Expiration' => 10,
                'gcFreq'=>1
            )
        );
        $captchaImage->setImgDir($dirdata . '/img/captcha');
        $captchaImage->setImgUrl('/img/captcha');
        $captchaImage->setFontSize(20);
        $captchaImage->setMessage('invalide image code');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password',
            ),
        ));
        $this->add(array(
            'name' => 'repeatpassword',
            'type' => 'Password',
            'options' => array(
                'label' => 'Repeat Password',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Enter image code',
                'captcha' => $captchaImage,
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}
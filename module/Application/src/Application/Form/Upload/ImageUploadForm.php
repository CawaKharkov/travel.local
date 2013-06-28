<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Application\Form\Upload;
/**
 * Description of ImageUploadForm
 *
 *  Form for uploading user images
 * @author Cawa
 */

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter;
use caUser\Exception\WrongArgumentException;
use caUser\Exception\IOException;

class ImageUploadForm extends Form
{
  
    public $user_id;


    public function __construct($name = null, $options = array(),$userId)
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setUserId($userId);
        $this->addInputFilter();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Select Image')
             ->setAttribute('id', 'image-file')
             ->setAttribute('title', 'Browse')
             ->setAttribute('class', 'fileupload');
        $this->add($file);
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload',
                'class' => 'btn small',
            ),
        ));
    }
    
     public function addInputFilter()
    {
         $inputFilter = new InputFilter\InputFilter();

        // File Input
        $fileInput = new InputFilter\FileInput('image-file');
        $fileInput->setRequired(true);
        
        
         $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 2004800))
            //->attachByName('filemimetype',  array('mimeType' => 'image/png,image/jpg,image/jpeg'))
            ->attachByName('fileimagesize', array('maxWidth' => 4000, 'maxHeight' => 4000));

        // All files will be renamed, i.e.:
        //   ./data/tmpuploads/avatar_4b3403665fea6.png,
        //   ./data/tmpuploads/avatar_5c45147660fb7.png
         
        $userDir = $this->chechkUserDir(); 
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target' => $userDir . 'image.jpg',
                'randomize' => true,
            )
        );
        
        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }

    protected function setUserId($userId)
    {
        if(is_numeric($userId) && !empty($userId)){
            $this->user_id = $userId;
        }else{
            throw new WrongArgumentException('ImageUpload: wrong user id');
        }
    }
    
    public function chechkUserDir() 
    {
        $path = BASE_DIR . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR .
                'data' . DIRECTORY_SEPARATOR . 'images_upload' .
                DIRECTORY_SEPARATOR . $this->user_id .DIRECTORY_SEPARATOR;
        if (is_dir($path)) {
            return $path;
        } else {
            if (mkdir($path) == false){
                throw new IOException('Can not create upload directory for user, userId: '.$this->user_id);
            }
        }
    }
}

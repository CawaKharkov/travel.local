<?php
/*
 * @author Cawa
 * 
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class AbstractController extends AbstractActionController
{
   
   public function acl()
   {
        $sm = $this->getServiceLocator(); 
        $aclService = $sm->get('AclService');
        if(!$aclService->canAcces){
            $this->redirect()->toRoute('error', ['action' => 'access']);
            //die();
        }
    }
    
}

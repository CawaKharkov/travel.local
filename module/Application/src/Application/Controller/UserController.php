<?php
/**
 * Description of UserController
 *
 * @author Cawa
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class UserController extends AbstractController
{
    
    
    public function indexAction()
    {
        
        return new ViewModel();
    }
	
}

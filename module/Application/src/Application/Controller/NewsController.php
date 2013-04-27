<?php
/**
 * Description of NewsController
 *
 * @author Cawa
 */

namespace Application\Controller;

use Zend\View\Model\ViewModel;

class NewsController extends AbstractController
{
    
    
    public function indexAction()
    {
        
        return new ViewModel();
    }
	
}

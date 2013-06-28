<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\Mvc\MvcEvent;
use caUser\View\Helper\ControllerName;

class Module implements AutoloaderProviderInterface
{
    public function onBootstrap(EventInterface $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager = $e->getApplication()->getEventManager();

        $e->getApplication()->getServiceManager()->get('viewhelpermanager')->setFactory('controllerName', function($sm) use ($e) {
                    $viewHelper = new ControllerName($e->getRouteMatch());
                    return $viewHelper;
                });

        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $eventManager->attach('render', array($this, 'initView'));
        $eventManager->attach('dispatch', array($this, 'initService'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function initView(EventInterface $e)
    {
        $helperManager = $e->getApplication()->getServiceManager()->get('viewhelpermanager');

        $helperManager->get('headmeta')->setCharset('utf-8')
                                       ->setName('viewport', 'width=device-width, initial-scale=1.0');
        
        $helperManager->get('headtitle')->set('TravelAround '. 'Клуб путешественников')->setSeparator(' - ')->setAutoEscape(false);
        
        $helperManager->get('headlink')
                        ->appendStylesheet('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css', '')
                        ->appendStylesheet('/css/font-awesome.min.css', '') 
                        ->appendStylesheet('/css/font-awesome-corp.css', '') 
                        ->appendStylesheet('/css/font-awesome-ext.css', '') 
                        ->appendStylesheet('/css/font-awesome-social.css', '') 
                        ->appendStylesheet('/css/menu/core.css', '') 
                        ->appendStylesheet('/css/menu/styles/lsteel-blue.css', '') 
                        ->appendStylesheet('/css/menu/effects/fading.css', 'media', array('conditional' => 'gt IE 9')) 
                        ->appendStylesheet('/css/fullwidth.css') 
                        ->appendStylesheet('/css/rs-plugin/css/settings.css') 
                        ->appendStylesheet('/css/captions.css', '') 
                        ->appendStylesheet('/css/animate.min.css', '') 
                        ->appendStylesheet('/css/prettify.css', '') 
                        ->appendStylesheet('/css/docs.css', '') 
                        ->appendStylesheet('/css/prettyPhoto.css', '') 
                        ->appendStylesheet('/css/main.css', ''); 
        
        $helperManager->get('headscript')
                                      ->appendFile('/js/vendor/selectivizr.min.js', 'text/javascript', array('conditional' => '(gte IE 6)&(lte IE 8)',))
                                      
                                      ->appendFile('/http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js', 
                                                    'text/javascript', array('conditional' => 'lt IE 9',))
                                      ->appendFile('/js/vendor/modernizr.min.js') 
                                      ->appendFile('//code.jquery.com/jquery-1.10.1.min.js') 
                                      ->appendFile('//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js') 
                                      ->appendFile('/js/vendor/jquery.easing.min.js') 
                                      ->appendFile('/css/rs-plugin/js/jquery.themepunch.plugins.min.js') 
                                      ->appendFile('/css/rs-plugin/js/jquery.themepunch.revolution.min.js') 
                                      ->appendFile('/js/vendor/jquery.jcarousel.min.js')
                                      ->appendFile('/js/vendor/jquery.flexslider.min.js') 
                                      ->appendFile('/js/vendor/jquery.parallax.min.js') 
                                      ->appendFile('/js/vendor/jquery.waypoints.min.js') 
                                      ->appendFile('/js/effects.js') 
                                      ->appendFile('/js/vendor/jquery.prettyPhoto.min.js') 
                                      ->appendFile('/js/vendor/jquery.cookie.min.js') 
                                      ->appendFile('/js/plugins.js') 
                                      ->appendFile('/js/main.js') 
                                      ->appendFile('/js/thirdparty/bootstrap.file-input.js') 
                                      ->appendFile('/js/vendor/jquery.placeholder.min.js', 'text/javascript', 
                                                                        array('conditional' => 'lte IE 9',)) 
                                      ->appendFile('/js/vendor/jquery.menu.min.js', 'text/javascript',
                                                                        array('conditional' => 'lte IE 9',));
        
    }
    
    
    
     
    public function initService(EventInterface $e)
    {
    }
    
    public function getViewHelperConfig()
    {
        return array(
            'invokables' => array(
                'loginHelper' => 'Application\View\Helper\LoginHelper',
                'userInfoHelper' => 'caUser\View\Helper\UserInfoHelper' 
            ),
        );
    }
 
}

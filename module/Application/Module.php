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
        
        /*
        $helperManager->get('headlink')
                        ->appendStylesheet('/css/bootstrap.css')
                        ->appendStylesheet('/css/bootstrap-responsive.css')
                        ->appendStylesheet('/css/main.css')
                        ->appendStylesheet('/js-plugin/pretty-photo/css/prettyPhoto.css')
                        ->appendStylesheet('/js-plugin/rs-plugin/css/settings.css')
                        ->appendStylesheet('/js-plugin/hoverdir/css/style.css')
                        ->appendStylesheet('/font-icons/custom-icons/css/custom-icons.css')
                        ->appendStylesheet('/font-icons/custom-icons/css/custom-icons-ie7.css')
                        ->appendStylesheet('/css/layout.css')
                        ->appendStylesheet('/css/light.css');
                        //->appendStylesheet('/css/colors.css');
        
        
        $helperManager->get('headscript')->appendFile('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js')
                                         ->appendFile('//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js')
                                         ->appendFile('/js/bootstrap.js')
                                         ->appendFile('/js/main.js')
                                         ->appendFile('/js/admin.js')
                                         ->appendFile('/js/custom.js')
                                         ->appendFile('/js/jquery.form.js')
                                         ->appendFile('/js/thirdparty/modernizr-2.6.1.min.js')
                                         ->appendFile('/js/thirdparty/bootstrap.file-input.js')
                                         ->appendFile('/js-plugin/respond/respond.min.js')
                                         ->appendFile('/js-plugin/easing/jquery.easing.1.3.js')
                                         ->appendFile('/js-plugin/pretty-photo/js/jquery.prettyPhoto.js')
                                         ->appendFile('/js-plugin/seaofclouds-tweet/tweet/jquery.tweet.js')
                                         ->appendFile('/js-plugin/hoverdir/jquery.hoverdir.js')
                                         ->appendFile('/js-plugin/rs-plugin/js/jquery.themepunch.plugins.min.js')
                                         ->appendFile('/js-plugin/rs-plugin/js/jquery.themepunch.revolution.min.js');*/
        $helperManager->get('headlink')
                        ->appendStylesheet('/css/bootstrap.css')
                        ->appendStylesheet('/css/bootstrap-responsive.css')
                        ->appendStylesheet('/css/font-awesome.min.css')
                        ->appendStylesheet('/css/font-awesome-corp.css')
                        ->appendStylesheet('/css/font-awesome-ext.css')
                        ->appendStylesheet('/css/font-awesome-social.css')
                        ->appendStylesheet('/css/menu/core.css')
                        ->appendStylesheet('/css/menu/styles/lsteel-blue.css')
                        ->appendStylesheet('/css/menu/effects/slide.css')
                        ->appendStylesheet('/css/fullwidth.css')
                        ->appendStylesheet('/css/rs-plugin/css/settings.css')
                        ->appendStylesheet('/css/captions.css')
                        ->appendStylesheet('/css/animate.min.css')
                        ->appendStylesheet('/css/prettify.css')
                        ->appendStylesheet('/css/docs.css')
                        ->appendStylesheet('/css/prettyPhoto.css')
                        ->appendStylesheet('/css/main.css')
                        ->appendStylesheet('/css/skins/default.css');

        $helperManager->get('headscript')->appendFile('/js/vendor/modernizr.min.js')
                                         ->appendFile('/js/vendor/jquery.min.js')
                                         ->appendFile('/js/vendor/bootstrap.min.js');
                                        // ->appendFile('/js/vendor/retina.js');
        
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

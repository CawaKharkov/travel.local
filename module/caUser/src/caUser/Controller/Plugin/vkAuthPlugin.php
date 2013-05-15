<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vkAuth
 *
 * @author Cawa
 */
namespace caUser\Controller\Plugin;


use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\Http\Request;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;


class vkAuthPlugin extends AbstractPlugin
{
    protected $session;

    public function __construct()
    {
        
        $this->session = new Container('user');
        
    }

    /* 
     * 
     * @param ServiceManager $serviceManager
     * @param Request $request
     * @return bool|string return true if access is grand and error if something went wrong
     */
    public function auth(ServiceManager $serviceManager, Request $request)
    {
        $config = $serviceManager->get('config');


        if (!$this->session->access_token && !$this->session->user_id) {
            $config = $config['socialAuth'];


            $url = $config['vkontakte']['authUrl'] . '?redirect_uri=' .
                    $config['vkontakte']['redirectUrl'] .
                    '&client_id=' . $config['vkontakte']['appId'];

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $authResponse = curl_exec($curl);
            curl_close($curl);

            echo $authResponse;

            if ($request->getQuery()->code) {
                $url = $config['vkontakte']['tokenUrl'] . '?redirect_uri=' .
                        $config['vkontakte']['redirectUrl'] .
                        '&client_id=' . $config['vkontakte']['appId']
                        . '&client_secret=' . $config['vkontakte']['appSecret']
                        . '&code=' . $request->getQuery()->code;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

                $response = \Zend\Json\Json::decode(curl_exec($curl));
                curl_close($curl);
                if (isset($response->error)) {
                    return $response->error_description;
                    // = ;
                } else {
                    $this->session->access_token = $response->access_token;
                    $this->session->user_id = $response->user_id;
                    $this->session->social_auth = true;
                    return true;
                }
            }
        }else{
            return true;
        }
    }
    
}
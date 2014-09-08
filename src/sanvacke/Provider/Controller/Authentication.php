<?php

namespace sanvacke\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Authentication implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers
            ->get('login', array($this, 'login'))
            ->method('GET|POST')
            ->bind('auth.login');
        $controllers
            ->get('logout', array($this, 'logout'))
            ->bind('auth.logout');

        return $controllers;
    }

    public function login(Application $app) {
        //\phpCAS::client(SAML_VERSION_1_1, 'login.ugent.be',443,'', true, 'saml');
        //\phpCAS::forceAuthentication();
        if ($app['session']->get('user')) {
            return $app->redirect($app['url_generator']->generate('dictshop'));
        }

        $user = array('name' => 'sander', 'admin' => true );
        $app['session']->set('user', $user);
        return $app->redirect($app['url_generator']->generate('auth.login'));

        return 'nu aangemeld';
    }

    public function logout(Application $app) {
        $app['session']->remove('user');
        return $app->redirect($app['url_generator']->generate('auth.login'));
    }
}
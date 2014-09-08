<?php

namespace sanvacke\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class Orders implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers
            ->match('/review', array($this, 'review'))
            ->before(array($this, 'checkLogin'))
            ->bind('order.review');

        return $controllers;
    }

    public function review(Application $app) {
        $user = $app['session']->get('user');

        return 'review this shit';
    }

    public function checkLogin(\Symfony\Component\HttpFoundation\Request $request, Application $app) {
        if(!$app['session']->get('user')) {
            return $app->redirect($app['url_generator']->generate('auth.login'));
        }
    }

}
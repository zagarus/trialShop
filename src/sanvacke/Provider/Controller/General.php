<?php

namespace sanvacke\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;


class General implements ControllerProviderInterface {
    public function connect(Application $app) {
        $controllers = $app['controllers_factory'];
        $controllers
            ->get('/', array($this, 'dictshop'))
            ->before(array($this, 'checkLogin'))
            ->bind('dictshop');
        $controllers
            ->get('/pc/{pcId}', array($this, 'detail'))
            ->assert('pcId', '\d+')
            ->before(array($this, 'checkLogin'))
            ->bind('dictshop.detail');
        $controllers
            ->get('/premier', array($this, 'premier'))
            ->before(array($this, 'checkLogin'))
            ->bind('dictshop.premier');
        $controllers
            ->get('/add', array($this, 'add'))
            ->before(array($this, 'checkLogin'))
            ->method('GET|POST')
            ->bind('dictshop.add');
        $controllers
            ->get('delete/{pcId}', array($this, 'delete'))
            ->before(array($this, 'checkLoginAuth'))
            ->method('GET|POST')
            ->bind('dictshop.delete');
        $controllers
            ->get('edit/{pcId}', array($this, 'edit'))
            ->before(array($this, 'checkLoginAuth'))
            ->method('GET|POST')
            ->bind('dictshop.edit');
        return $controllers;
    }

    public function dictshop(Application $app) {
        $pcs = $app['db.pc']->findAll();
        //var_dump($pcs);
        return $app['twig']->render('general/dictshop.twig', array('user' => $app['session']->get('user'), 'pcs' => $pcs));
    }

    public function detail(Application $app, $pcId) {
        $pc = $app['db.pc']->find($pcId);
        return $app['twig']->render('general/detail.twig', array(
            'user' => $app['session']->get('user'),
            'pc' => $pc
        ));
    }

    public function add(Application $app) {
        $addform = $app['form.factory'];

        $addform = $app['form.factory']->createNamed('addform', 'form', $pc)
            ->add('name', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('type', 'choice', array(
                'choices' => array(
                    'laptop' => 'laptop',
                    'desktop' => 'desktop',
                    'other' => 'other'
                ),
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('price', 'integer', array(
                'label' => 'Price in EUR',
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('cpu', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('gpu', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('hdd', 'textarea', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('ram', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('omschrijving', 'textarea', array(
                'constraints' => array(new Assert\NotBlank())
            ));

        if ('POST' == $app['request']->getMethod()) {
            $addform->bind($app['request']);
            //var_dump($editform);
            if($addform->isValid()) {
                $data = $addform->getData();

                var_dump(($data));
                $app['db.pc']->insert($data);
            }
        }


            }

    public function edit(Application $app, $pcId) {
        $pc = $app['db.pc']->find($pcId);

        if($pc === false) {
            return $app->redirect($app['url_generator']->generate(dictshop));
        }

        $editform = $app['form.factory']->createNamed('editform', 'form', $pc)
            ->add('name', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('type', 'choice', array(
                    'choices' => array(
                        'laptop' => 'laptop',
                        'desktop' => 'desktop',
                        'other' => 'other'
                    ),
                   'constraints' => array(new Assert\NotBlank())
            ))
            ->add('price', 'integer', array(
                'label' => 'Price in EUR',
                'constraints' => array(new Assert\NotBlank())
           ))
            ->add('cpu', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('gpu', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('hdd', 'textarea', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('ram', 'text', array(
                'constraints' => array(new Assert\NotBlank())
            ))
            ->add('omschrijving', 'textarea', array(
                'constraints' => array(new Assert\NotBlank())
            ));

        if ('POST' == $app['request']->getMethod()) {
            $editform->bind($app['request']);
            //var_dump($editform);
            if($editform->isValid()) {
                $data = $editform->getData();

            var_dump(($data));

            $app['db.pc']->update($data, array('id' => $pcId));

            return $app->redirect($app['url_generator']->generate('dictshop') . '?feedback=edited');

            }
        }

        return $app['twig']->render('general/edit.twig', array(
            'user' => $app['session']->get('user'),
            'pc' => $pc,
            'editform' =>$editform->createView()
        ));
    }

    public function premier(Application $app) {

        return 'random';
    }

    public function checkLogin(\Symfony\Component\HttpFoundation\Request $request, Application $app) {
        if(!$app['session']->get('user')) {
            return $app->redirect($app['url_generator']->generate('auth.login'));
        }
    }
    public function checkLoginAuth(\Symfony\Component\HttpFoundation\Request $request, Application $app) {
        if(!$app['session']->get('user') || !$app['session']->get('user')['admin']) {
            return $app->redirect($app['url_generator']->generate('dictshop'));
        }
    }
}
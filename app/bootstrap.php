<?php
// Require Composer Autoloader
require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Create new Silex App
$app = new Silex\Application();

$app['paths'] = array(
    'root' => __DIR__ . '/..',
    'web' => __DIR__ . '/../web',
);

// App Configuration
$app['debug'] = true;

// Use Twig — @note: Be sure to install Twig via Composer first!
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . DIRECTORY_SEPARATOR . '/..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR .'sanvacke' . DIRECTORY_SEPARATOR . 'views'
));

// Use Doctrine — @note: Be sure to install Doctrine via Composer first!
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'webshop',
        'user'     => 'root',
        'password' => '',
        'charset'   => 'utf8',
        'driverOptions' => array(
            1002 => 'SET NAMES utf8'
        )
    )
));

// Use Repository Service Provider — @note: Be sure to install KNP RSP via Composer first!
$app->register(new Knp\Provider\RepositoryServiceProvider(), array(
    'repository.repositories' => array(
        'db.pc' => 'sanvacke\\Repository\\pcRepository',
    )
));

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\FormServiceProvider());

$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'translator.messages' => array(),
));

$app->register(new Silex\Provider\SwiftmailerServiceProvider(), array(
    'swiftmailer.options' => array(
        'host' => 'host',
        'port' => '25',
        'username' => 'username',
        'password' => 'password',
        'encryption' => null,
        'auth_mode' => null
    )
));
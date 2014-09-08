<?php

// Bootstrap
require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'cas-ugent-php' . DIRECTORY_SEPARATOR . 'CAS-1.3.1' . DIRECTORY_SEPARATOR . 'CAS.php';

$app->error(function (\Exception $e, $code) {
    if ($code == 404) {
        return '404 - Not Found! // ' . $e->getMessage();
    } else {
        return 'Shenanigans! Something went horribly wrong // ' . $e->getMessage();
    }
});


$app->mount('/order', new sanvacke\Provider\Controller\Orders());
$app->mount('/pc', new sanvacke\Provider\Controller\General());
$app->mount('/', new sanvacke\Provider\Controller\General());
$app->mount('/auth', new sanvacke\Provider\Controller\Authentication());


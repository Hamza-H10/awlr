<?php

require 'vendor/autoload.php';

use Slim\App;

$app = new App();

$app->get('/hello', function () {
    echo 'Hello World!';
});

$app->run();
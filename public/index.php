<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Koala\Application;
use App\Config\Routes;

$app = new Application();
Routes::register($app->getRouter());
$app->start(__DIR__ . '/../config.php');

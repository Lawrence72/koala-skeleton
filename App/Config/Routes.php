<?php

namespace App\Config;

use App\Controllers\Home_Controller;
use Koala\Router\Router;

class Routes
{
	public static function register(Router $router): void
	{
		$router->addRoute('GET', '', Home_Controller::class, 'home');
	}
}
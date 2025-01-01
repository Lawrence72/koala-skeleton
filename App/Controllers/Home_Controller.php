<?php

namespace App\Controllers;

use Koala\Application;
use Koala\Request\Request;
use Koala\Response\Response;
use Koala\Response\ResponseInterface;

class Home_Controller
{
	public function __construct(
		protected Application $app,
	) {}

	public function home(Request $request, Response $response, $args): ResponseInterface
	{
		return $response->view('index', []);
	}
}

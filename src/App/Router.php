<?php

namespace FramePHP\App;

/**
* 
*/
class Router extends AltoRouter
{
	// public function __construct( $routes = array(), $basePath = '', $matchTypes = array() ) {

	// 	parent::__construct($routes, $basePath, $matchTypes);
	// }

	public function process($request)
	{
		dump($request);
	}	
	
}
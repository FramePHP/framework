<?php

namespace FramePHP\Http;

use PHPRouter\RouteCollection;
use PHPRouter\Config;
use PHPRouter\Router;
use PHPRouter\Route;


/**
* 
*/
class Routing
{
	public function loadRoutes($routes, $base_path = null)
	{
		if(is_array($routes) && count($routes)){
			$collection = new RouteCollection();

			foreach ($routes as $name => $route) {
				$url = '/'.(trim($route['url'] ?? $route[0])).'/';
				$_controller = $route['_controller'] ?? $route[1];
				$methods = $route['methods'] ?? $route[2];

				$args = compact('_controller', 'methods');

				$collection->attachRoute(new Route($url, $args));
			}
			$Router = new Router($collection);
			$Router->setBasePath($base_path ?? '/');
			return $Router->matchCurrentRequest();
		}
		elseif(is_string($routes) && str_has($routes, '.yml')){
			$config = Config::loadFromFile($routes);
		    $Router = Router::parseConfig($config);
		    return $Router->matchCurrentRequest();
		}
		
	}

	public function makeRoutes()
	{
		
	}
}
<?php

namespace FramePHP\Http;

use League\Route\{Route, RouteCollection};
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

use Closure, Controller;
use FramePHP\App\Application;

/**
*
*/
class Routing extends RouteCollection
{
	protected $_routes = array();

	public function __construct($App, $routes = null)
	{
		$this->load($routes)->make();
		parent::__construct( $App );
	}

	public function load($routes_dir)
	{
		if(!($RoutesDir = realpath($routes_dir))) return;

		$RoutePaths = glob($RoutesDir.'/*', GLOB_NOSORT);

		foreach ($RoutePaths as $route_path) {
			$routes = require realpath($route_path);

			if($routes && is_string($routes)){
				$this->fromFiles($routes);
			}
			if($routes && is_array($routes)){
				$this->fromPaths($routes);
			}
		}
		return $this;
	}

	public function fromFiles($route_file ='')
	{
		# code...
		$_routes = [];
		return $this->_routes = $_routes;
	}

	public function fromPaths($route_paths = [])
	{
		return $this->_routes = $route_paths;
	}


	public function make()
	{

		foreach ($this->_routes as $url => $params) {
			$url = '/'.trim($url);
			if(array_key_exists('controller', $params)){
				extract($params);
			}
			elseif((float)phpversion() >= 7){
				list($method, $controller) = $params;
			}
			else{
				list($controller, $method) = $params;
			}
			$callable = $this->getCallable($controller);
			$_method  = $this->getMethod($method);
			$this->map($_method, $url, $callable);
		}

		return $this;
	}

	public function getCallable($callable)
	{
		if($callable instanceof Closure) $callable = $callable();
		list($controller, $action) = array_pad($callable, 2, '__invoke');
		return [$controller, $action];
	}

	public function getMethod($method)
	{
		$_method = strtoupper($method);
		if($_method == 'ANY') $_method = 'GET';
		return $_method;
	}

}

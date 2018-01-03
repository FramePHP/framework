<?php

namespace FramePHP\App;

use Closure;
use FramePHP\Http\Response;
use FramePHP\Http\Request;
use FramePHP\Http\Routing;
use FramePHP\Http\Session;
use FramePHP\Auth\Config;
/**
* 
*/
class Application
{	
	private $Routing  = Routing::class;
	private $Request  = Request::class;
	private $Response = Response::class;
	private $Session  = Session::class;
	private $Config   = Config::class;
	private $Viewer   = Viewer::class;

	private static $Instance;

	private function __construct()
	{	
		$this->Routing = new Routing();
		$this->Config  = new Config();
	}

	public static function Instance()
	{
		if(empty(static::$Instance)){

			static::$Instance = new Application();
		}
		return static::$Instance;		
	}

	public function setRequest(Closure $Callback = null)
	{
		$this->Request = Request::createFromGlobals();
        return static::$Instance;
	}

	public function getRequest(Closure $Callback = null)
	{
		return $this->Request;
	}

	public function setRouting(Closure $Callback = null)
	{
		$routes = $Callback();
		$this->Routing->loadRoutes($routes);

		return static::$Instance;
	}

	public function getRouting(Closure $Callback = null)
	{
		return $this->Routing;
	}

	public function setResponse(Closure $Callback = null)
	{
		$type = $Callback();
		// $this->Response = new Response('hi', 200, [
		// 	'Content-Type' => 'text/application'
		// ]);
        return static::$Instance;
	}

	public function getResponse()
	{
		# code...
		return $this->Response;
	}

	public function run()
	{
		$app_time = microtime(true) - APP_START_TIME;
		dump($app_time, $this);
		return static::$Instance;
	}
}
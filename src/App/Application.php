<?php

namespace FramePHP\App;

use Closure;
use FramePHP\Http\Response;
use FramePHP\Http\Request;
use FramePHP\Auth\Configs;

/**
*
*/
class Application
{
	private $Configs  = Config::class;
	private $Routing  = Routing::class;
	private $Request  = Request::class;
	private $Response = Response::class;

	private static $Instance  = null;

	private function __construct()
	{
		$this->Configs = new Configs();
		$this->Routing = new Routing();
	}

	public static function Instance()
	{
		if(static::$Instance == null){

			static::$Instance = new Application();
		}
		return static::$Instance;
	}

	public function setRequest(Closure $Callback = null)
	{
		$this->Request = Request::createFromGlobals();

        return static::$Instance;
	}

	public function getRequest()
	{
		return $this->Request;
	}

	public function setRouting(Closure $Callback = null)
	{
		$routes = $Callback($this->Configs->routes);
		$this->Routing->loadRoutes($routes);
		return static::$Instance;
	}

	public function getRouting()
	{
		return $this->Routing;
	}

	public function setResponse($type = 'Content')
	{
		// $this->Response = new Response(
		// 	$type,
		// 	200,
		// 	array('content-type' => 'text/html')
		// );
        return static::$Instance;
	}

	public function getResponse()
	{
		# code...
	}

	public function run()
	{
		$app_time = APP_START_TIME - microtime(true);
		dump($app_time, $this);
		return static::$Instance;
	}
}

<?php

namespace FramePHP\App;

use Closure;
use FramePHP\Http\Response;
use FramePHP\Http\Request;

/**
* 
*/
class Application
{	
	private $Routing  = Routing::class;
	private $Request  = Request::class;
	private $Response = Response::class;
	private static $Instance  = null;

	private function __construct()
	{	
		$this->Routing = new Routing();
	}

	public static function Instance()
	{
		if(static::$Instance == null){

			static::$Instance = new Application();
		}
		return static::$Instance;		
	}

	public function getRequest(Closure $Callback = null)
	{
		//Get the request from Users
		dump($Callback(''));
		$this->Request = Request::createFromGlobals();	
		dump($this->Request);	

        return static::$Instance;
	}

	public function getRouting(Closure $Callback = null)
	{
		$routes = $Callback();
		$this->Routing->loadRoutes($routes);

		return static::$Instance;
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
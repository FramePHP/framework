<?php

namespace FramePHP\App;

use FramePHP\Http\Response;
use FramePHP\Http\Request;

/**
* 
*/
class Application
{	
	private $Router = Router::class;
	private $Request  = Request::class;
	private $Response = Response::class;
	static $Instance  = null;

	private function __construct()
	{	
		$this->Router = new Router();	
	}

	public static function Instance()
	{
		if(static::$Instance == null){

			static::$Instance = new Application();
		}
		return static::$Instance;		
	}

	public function getRequest()
	{
		//Get the request from Users
		$this->Request = Request::createFromGlobals();

		//Redirect request to Router;
		$this->Router->process($this->Request);

        return static::$Instance;
	}

	public function setResponse($type = 'Content')
	{
		$this->Response = new Response(
			$type,
			static::HTTP_OK,
			array('content-type' => 'text/html')
		);
        return static::$Instance;
	}

	public function getResponse()
	{
		# code...
	}

	public function run($stop_time)
	{
		$app_time = APP_START_TIME - $stop_time;
		dump($app_time, $this, static::$Instance);
		return static::$Instance;
	}
}
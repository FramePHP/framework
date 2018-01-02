<?php

namespace FramePHP\App;

use FramePHP\Http\Response;
use FramePHP\Http\Request;

/**
* 
*/
class Application
{
	static $Instance = null;

	private function __construct()
	{
		# code...
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
		$Request = Request::createFromGlobals();
        dump($Request);
        return $this;
	}

	public function setResponse()
	{
		$Request = Request::createFromGlobals();
        dump($Request);
        return $this;
	}

	public function run($stop_time)
	{
		$app_time = APP_START_TIME - $stop_time;
		dump($app_time);
	}
}
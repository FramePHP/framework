<?php

namespace FramePHP\App;

use Closure, Exception;
use FramePHP\Http\Response;
use FramePHP\Http\Request;
use FramePHP\Http\Routing;
use FramePHP\Auth\Configs;
use Zend\Diactoros\Response\SapiEmitter;

/**
*
*/
class Application extends Container
{

	private static $Instance  = null;

	private $Configs;//  = Config::class;
	private $Routing;//  = Routing::class;
	private $Request;//  = Request::class;
	private $Response;// = Response::class;

	protected $app_root, $instance, $app_env;

	public static function Instance($args = [])
	{
		if(self::$Instance == null){

			self::$Instance = new Application();
		}
		if($args){
			foreach ($args as $key => $value) {
				self::$Instance->bind($key, $value);
			}
		}
		return self::$Instance;
	}

	// public function __set($key, $value = null)
	// {
	// 	if(is_array($key)){
	// 		foreach ($key as $k => $val) {
	// 			if(property_exists($this, $k)){
	// 				$this->{$k} = $val;
	// 			}
	// 			else{
	// 				$this->set($k, $val);
	// 			}
	// 		}
	// 		return;
	// 	}
	// 	if(property_exists($this, $key)){
	// 		$this->{$key} = $value;
	// 	}
	// 	else{
	// 		$this->set($key, $value);
	// 	}
	// 	return $this;
	// }
  //
	// public function __get($key)
	// {
	// 	if(property_exists($this, $key)){
	// 		return $this->{$key};
	// 	}
	// 	return $this->get($key) ?? "$key is not set";
	// }

	public static function isRunning()
	{
		if(self::$Instance !== false) return self::$Instance;
		throw new \Exception("Application is not running", 1);

	}
  //
	public function dispatch()
	{
		$router   = $this->get('Routing');
		$request  = $this->get('Request');
		$response = $this->get('Response');

		try {
			$dispatch = $router->dispatch($request, $response);
			$response = $this->get('Emitter')->emit( $dispatch );
			return $response;
		}
		catch (Exception $e) {
			print $this->generateCallTrace($e);
		}

	}

	public function terminate( $start_time)
	{
		$response = $this->dispatch();

		$this->app_time = round(microtime(1) - $start_time, 5);
		$this->app_mem  = round(memory_get_usage(0) / 1024, 3);

		if($this->get('app_env') == 'DEV'){
			dump(
				'Running time: '.($this->app_time = round(microtime(1) - $start_time, 5).'ms'),
				'Memory used: '.($this->app_mem = round(memory_get_usage(0) / 1024, 3).'kb')
			);
		}
		return $response;
	}

	public function serve($provider)
	{
		$this->addServiceProvider($provider);
		return  $this;
	}

	public function boot($provider)
	{
		return $this->addServiceProvider($provider, true);
	}

	function generateCallTrace(Exception $e)
	{
		$trace = explode("\n", $e->getTraceAsString());
		// reverse array to make steps line up chronologically
		$trace = array_reverse($trace);
		array_shift($trace); // remove {main}
		array_pop($trace); // remove call to this method
		$length = count($trace);
		$result = array();

		for ($i = 0; $i < $length; $i++)
		{
			$result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
		}
    print '<div style="background-color:darkblue;color:white; line-height:1; padding:0.5rem">';
		print("<h1>".$e->getMessage()."</h1>");
		print("<h3>Line ".$e->getLine().": ".$e->getFile()." [Error code: ".$e->getCode()."]</h3>");
		print "</div><pre>";
		print "\t" . implode("\n\t", $result);
		print "</pre>";
	}
}

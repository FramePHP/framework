<?php

namespace FramePHP\App;

/**
* 
*/
abstract class Controller
{

	public function __call($method, $params = [])
	{
		$class = get_called_class();
		if(!method_exists($class, $method)){
			$func = array($this, 'missingAction');
			$args = array($method, $params);
			return call_user_func_array($func, $args);
		}		
	}

	public function getAction($method, $args = [])
	{

	}

	public function postAction($method, $args = [])
	{
		
	}

	public function putAction($method, $args = [])
	{
		
	}

	public function patchAction($method, $args = [])
	{
		
	}

	public function deleteAction($method, $args = [])
	{
		
	}	

	public function missingAction($args = null)
	{
		dump($args);

	}
}
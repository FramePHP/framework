<?php

namespace FramePHP\App;

/**
* 
*/
class Route extends AltoRouter
{	

	public function get($url, $args)
	{

		$this->map('GET', $url, function($args){
           dump($url, $args);
		});

		$match = $router->match();
	}

	public function match($match)
	{
		$match = $router->match();

		if( $match && is_callable( $match['target'] ) ) {
			call_user_func_array( $match['target'], $match['params'] ); 
		} 
		else {
			header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
		}
	}
	
}
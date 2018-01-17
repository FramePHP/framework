<?php

use FramePHP\App\Application as App;

if(!function_exists('config')){
	function config($args)
	{

	}
}

if(!function_exists('str_ext')){
	function str_has($haystack, $needle)
	{
		return strpos($haystack, $needle) !== false;
	}
}

if(!function_exists('redirect')){
	function redirect($haystack, $needle)
	{
		return App::instance()->get('Redirect');
	}
}

if(!function_exists('request')){
	function request($haystack, $needle)
	{
		return App::instance()->get('Request');
	}
}


if(!function_exists('response')){
	function response($haystack, $needle)
	{
		return App::instance()->get('Response');
	}
}

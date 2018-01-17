<?php

use FramePHP\App\Application;

if(!function_exists('app')){

	function app($key = null)
	{
		$App = Application::isRunning();
		return $key != null? $App->get($key): $App;
	}

	function BP($key = null)
	{
		$BP = require APP_ROOT.'blueprint.php';
		return str_to_arr($BP, $key);
	}
}

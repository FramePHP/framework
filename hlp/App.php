<?php

use FramePHP\App\Application;

if(!function_exists('app')){

	function app($key = null)
	{
		$App = Application::isRunning();
		return $key != null? $App->get($key): $App;
	}
}

<?php

use FramePHP\View\Viewer;
use FramePHP\View\Template;

if(!defined('APP_ROOT')){
	define('APP_ROOT', realpath(__DIR__.'/../../'));
}

define('APP_PATH', realpath(APP_ROOT . '/app/'));
define('SYS_PATH', realpath(APP_ROOT . '/sys/'));
define('DATA_PATH', realpath(APP_ROOT . '/data/'));
define('PUB_PATH', realpath(APP_ROOT . '/public/'));

if(!function_exists('base_path')){
	function base_path($path = null, $create = false)
	{
		$path = realpath($raw = APP_ROOT."/$path");
		if(!$path && $create) mkdir($raw, 0775, true);
		return $path;
	}
}


if(!function_exists('app_path')){

	function app_path($path, $create = false)
	{
		$path = realpath($raw = APP_PATH."/$path");

		if(!$path && $create) mkdir($raw, 0775, true);

		return $path;
	}
}

if(!function_exists('view_path')){

	function view_path($path)
	{
		if(strpos($path, "::")){
		  list($app, $view) = explode("::", $path);
			$app = app_path("$app");
		}
		else{
			$view = $path;
			$dpb = debug_backtrace();
			$app = dirname(dirname($dpb[1]['file']));
		}
		return realpath("$app/templates/$view");
	}
}

if(!function_exists('layout')){

	function layout($path)
	{
		$path = "layouts.$path.php";
		$view = str_replace(".", "/", $path);
		return view_path($view)? $view: "missing.php";
	}
}

if(!function_exists('view')){

	function view($path, $data = [])
	{
		$path = str_replace(".", "/", $path).".php";
		$view = view_path($path)? $path: "missing.php";

		$tplt = app()->get('Template')->load($view);

		if (empty($data)) return $tplt;
		return $tplt->render($data);
	}
}

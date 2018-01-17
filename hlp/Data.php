<?php


if(!function_exists('str_to_arr')){
  function str_to_arr(&$arr, $string, $value = '', $separator = '.'){

    $keys = explode($separator, $string);

    foreach ($keys as $key) {
      $arr = &$arr[$key];
    }
    if($value != '')  $arr = $value;

    return $arr;
  }
}

if(!function_exists('config')){
  function config($path){
    $configs = str_to_arr($configs, $path);
    dump($configs);
  }
}

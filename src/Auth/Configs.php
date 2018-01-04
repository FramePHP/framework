<?php

namespace FramePHP\Auth;

/**
*
*/
class Configs
{
  private $configs = [];


  public function __construct()
  {
    # code...
  }

  public function __get($routes)
  {
    if(str_has($routes, $sep = '.')){
      return str_to_arr($this->configs, $routes);
    }
    else{
      return $this->configs[$routes];
    }
  }

  public function __set($routes, $value)
  {
    if(str_has($routes, $sep = '.')){
      str_to_arr($this->configs, $routes, $value);
    }
    else{
      $this->configs[$routes] = $value;
    }
    return $this->configs;
  }
}

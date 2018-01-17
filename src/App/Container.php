<?php

namespace FramePHP\App;

use Closure;

use League\Container\Container as LeagueContainer;
/**
*
*/
class Container extends LeagueContainer
{
  public function set($name, $param)
  {
    $call = ($param instanceof Closure)? $param(): $param;
    parent::add($name, $call);
    return $this;
  }
  public function bind($name, $param)
  {
    $call = ($param instanceof Closure)? $param(): $param;
    parent::share($name, $call);
    return $this;
  }

  public function get($name)
  {
    return parent::get($name);
  }
}

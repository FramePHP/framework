<?php

namespace FramePHP\App;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;

class Service extends AbstractServiceProvider implements BootableServiceProviderInterface
{
  protected $provides = [

  ];

  public function __construct()
  {
    # code...
  }

  public function boot(Closure $boot)
  {
    return $boot();
  }

  public function register()
  {
    foreach ($this->provides as $key => $value) {
      if(is_array($value)){
        list($val, $args) = each($value);
        $this->getContainer()->add($key, $val)->withArguments($args);

      }
      else{
        $this->getContainer()->add($key, $value);
      }
    }
  }
}

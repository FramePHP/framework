<?php

namespace FramePHP\View;

use Twig_Loader_Array;
use Twig_Loader_Filesystem;

class Loader
{
  private $load;

  public function __construct($params)
  {
    # code...
    if(is_array($params)){
      $this->load = new ArrayLoader($params);
    }
    else{
      $this->load = new Twig_Loader_Filesystem($params);
    }
    return $this;
  }

  public function load()
  {
    return $this->load;
  }
}

<?php

namespace FramePHP\View;

use Twig_Environment;
use Twig\Loader\ArrayLoader as Twig_Loader_Array;
use Twig\Loader\FilesystemLoader as Twig_Loader_Filesystem;

/**
*
*/
class Viewer
{
  private $loader;
  private $templates;
  private $usesFiles;
  private $viewer = [];
  private $configs = [];

  public function __construct($templates, $files = true)
  {
    $this->templates = $templates;
    $this->usesFiles = $files;

    parent::__construct($this->loader(), $this->configs());
    return $this;
  }

  public function configs()
  {
    $this->configs['cache'] = base_path('tmp/cache', true);
    $this->configs['debug'] = true;
    return $this->configs;
  }

  public function loader()
  {
    if($this->usesFiles){
      $this->loader = new Twig_Loader_Filesystem( $this->templates );
    }
    else{
      $this->loader = new Twig_Loader_Array( $this->templates );
    }
    return $this->loader;
  }

  // public function loadTemplate($view, $index = null)
  // {
  //   dump($this);
  //   return parent::loadTemplate(view($view, $index));
  // }

}

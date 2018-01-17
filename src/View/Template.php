<?php

namespace FramePHP\View;

use Twig_Environment;
use Twig\Loader\ArrayLoader as Twig_Loader_Array;
use Twig\Loader\FilesystemLoader as Twig_Loader_Filesystem;

/**
*
*/
class Template
{
  private $loader;
  private $templates;
  private $usesFiles;
  private $viewer = [];
  private $configs = [];
  private $environment;

  public function __construct($templates, $files = true)
  {
    $this->templates = $templates;
    $this->usesFiles = $files;
    $this->environment = new Twig_Environment($this->loader(), $this->configs());
    return $this;
  }

  public function configs()
  {
    $this->configs['cache'] = base_path('tmp/cache', true);
    $this->configs['debug'] = true;
    return $this->configs;
  }

  public function load()
  {
    if($this->usesFiles){
      $this->loader = new Twig_Loader_Filesystem( $this->templates );
    }
    else{
      $this->loader = new Twig_Loader_Array( $this->templates );
    }
    return $this;
  }

  public function loader()
  {
    if(empty($this->loader)){
      $this->load();
    }
    return $this->loader;
  }

  // public function loadTemplate($view, $index = null)
  // {
  //   dump($this);
  //   return parent::loadTemplate(view($view, $index));
  // }

}

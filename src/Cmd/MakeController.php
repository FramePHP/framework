<?php

namespace FramePHP\Cmd;

class MakeController
{

  public $Content = "<?php\n\n";
  public $location = __DIR__.'/../../../../';
  public $controller;
  public $className;
  public $extension;
  public $namespace;
  public $ds = DIRECTORY_SEPARATOR;

  public function __construct($className, $where)
  {
    $this->className = ucwords($className);
    $this->namespace = explode("/", $where);
    $this->location  = str_replace(['/','\\'], $this->ds, $where);
    $this->makeThisController();
  }

  public function makeThisController()
  {
    $c = $this->declareNamespaces();
    $c .= $this->makeClassContainer();
    $c .= $this->completeController();
  }

  public function declareNamespaces()
  {
    $namespaces = [];
    foreach ($this->namespace as $part) {
      $namespaces[] = ucwords($part);
    }
    $this->namespace = implode("\\", $namespaces);
    $this->Content .= "namespace $this->namespace;\n\n";
    $this->extension = array_pop($namespaces).'Controller';

    $this->Content .= "use $this->extension;\n\n";
  }

  public function makeClassContainer($type = '')
  {
    $this->Content .= "class $this->className extends $this->extension\n{\n\n";

      if($type == '--r' || $type == 'resource'){
        $this->Content .= $this->resourceController();
      }
      else{
        $this->Content .= $this->regularController();
      }
    }

  public function regularController()
  {
    foreach (['index' => '', 'create' => '', 'update' => ''] as $func => $args) {
      $this->Content .= $this->addFunction($func, $args);
    }

  }

  public function addFunction($name, $args = '', $params = null)
  {

    $function = "\tpublic function $name()\n\t{\n";
    $function .= "\t\treturn \$this->view();\n";
    $function .= "\t}\n\n";
    return $function;
  }

  public function get()
  {
    return $this->Content .= "}";
  }

  public function completeController()
  {
    $file = realpath(__DIR__.'/../../../../../'.$this->location).$this->ds;
    $this->location = $file.'controllers'.$this->ds.$this->className.'.php';

    if(file_exists($fname = $this->location)){
      print "File exists! creating a backup...\n";
      $oldData = "\n\n/*============== ".(date('m/d/y'))." ==============*/\n\n";
      file_put_contents($this->location.'.bak', $oldData.$this->get(), true);

      print "Creating new content...\n";
      $fdata   = file_get_contents($fname);
      $fhandle = fopen($fname, "r");
      $content = fread($fhandle, filesize($fname));
      $content = str_replace($fdata, $this->get(), $content);

      $fhandle = fopen($fname,"w");
      fwrite($fhandle, $content);
      fclose($fhandle);
    }
    else{
      file_put_contents($this->location, $this->get(), true);
    }
    print "Done!\n";
  }
}

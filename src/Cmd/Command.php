<?php

namespace FramePHP\Cmd;
use FramePHP\Http\Request;
// use Symfony\Component\Console\Command\Command as SymCommand;

// class Command extends SymCommand
class Command
{
  protected $action, $params, $cmd_root, $source;

  public function __construct( $argv = null)
  {
    $this->cmd_root = realpath(__DIR__.'/../../../../../');
    $this->source = array_shift($argv);
    $this->action = array_shift($argv);
    $this->params = $argv;
  }

  public function run()
  {
    $action = explode(":", $this->action ?? 'help');
    list($method, $type) = array_pad($action, 2, 'help');

    if(empty($action) || $action == 'help'){
        return $this->help();
    }
    if(method_exists($this, $method)){
      return $this->$method($type, $this->params);
    }
    else{
      print PHP_EOL.(">>>> '$this->action' is not a valid command!").PHP_EOL.PHP_EOL;
    }
  }

  public function help($value = null)
  {
    print (" \nCurrent commands ".($value? "for $value": "")." are:\n");
    print ("   frame make:app <dir> [options].\n");
    print ("   frame make:sys <dir> [options].\n");
    print ("      <dir>         Directory to be created (required).\n");
    print ("      [options]     Flags to pass to the command (optional).\n");
    print ("      --clone       Copy to new directory (default)\n");
    print ("      --new         Create in new directory\n");
    print ("      --help        Display this information\n");
  }

  public function make($name, $args = [])
  {
    switch ($name) {
      case 'help':
        return $this->help();
        break;
      case 'sys':
        print PHP_EOL;
        $sys = !(strpos($args[0], '--') !== false)? $args[0]: 'sys';
        if(in_array('--new', $args)){
          $this->make_new($name, $sys);
        }
        if(in_array('--clone', $args)){
          $this->make_clone($name, $name, $sys);
        }
        break;
      case 'app':
        $app = 'app/';
        $app .= !(strpos($args[0], '--') !== false)? $args[0]: 'site';
        if(in_array('--new', $args)){
          $this->make_new($name, $app);
        }
        if(in_array('--clone', $args)){
          $this->make_clone($name, "$name/site", $app);
        }
        break;
        case 'ctrl':
          $app = 'app/'; $controller = $args[1];
          $app .= !(strpos($args[0], '--') !== false)? $args[0]: 'site';
          $file = explode("\\", $class = $controller);
          new MakeController($class, $app, $app);
          break;
      default:
        print PHP_EOL.(">>>> 'make:$name is not a valid command!").PHP_EOL.PHP_EOL;
        break;
    }
  }

   public function make_new($name, $new)
   {
     print "Creating new module-$name into '$new' ...".PHP_EOL;
     shell_exec("[ ! -d $new ] || mv $new $new-copy");
     $this->move_mods($name, $new);
     print PHP_EOL.("  - Done!").PHP_EOL;
   }

   public function make_clone($name, $old, $new)
   {
     print "Cloning '$old' folder into '$new' ...".PHP_EOL;
     shell_exec("[ ! -d $app ] || rm -rf $app");
     shell_exec("cp -rf app $app");
     print PHP_EOL;
   }

   public function move_mods($name, $to)
   {
     shell_exec("[ -d vendor/frame-php/module-$name ] || composer require frame-php/module-$name");
     shell_exec("cp -rf ./vendor/frame-php/module-$name $to");
     shell_exec("composer remove frame-php/module-$name");
   }

   public function project()
   {
     shell_exec("cp -r composer.json installer.json");
     shell_exec("cp -r composer.lock installer.lock");
     shell_exec("cp -r README.md INSTALL.md");
     shell_exec("cp -r .env-sample .env");
     shell_exec("[ ! -d app/site ] || rm -rf app/site");
     shell_exec("mv ./vendor/frame-php/application/{.,}* ./ || true");
     shell_exec("mv ./vendor/frame-php/module-sys/* ./sys/ || true");
     shell_exec("mv ./vendor/frame-php/module-app/ ./app/site/ || true");
   }

   public function install()
   {
     $this->project();
   }

   public function update()
   {
     shell_exec("[ ! -f app/site/.git* ] || rm -rf app/site/.git*");
     shell_exec("[ ! -f app/site/*{.json,.md} ] || rm -rf app/site/*{.json,.md}");
     shell_exec("[ ! -f sys/.git* ] || rm -rf sys/.git*");
     shell_exec("[ ! -f sys/*{.json,.md} ] || rm -rf sys/*{.json,.md}");
   }

}

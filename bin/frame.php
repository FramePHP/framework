<?php

namespace FramePHP\Cmd;

$autoloaders = [
  __DIR__.'/../../../autoload.php',
  __DIR__.'/../autoload.php.dist',
  __DIR__.'/../autoload.php'
];


if (!class_exists(Command::class)) {
  foreach ($autoloaders as $file) {
    $path = realpath($file);

    if($path && file_exists($path)){
      require_once $path;
      break;
    }
  }
}

$argv = $_SERVER['argv'];
$Commander = new Command($argv);
//
// use PhpParser\NodeTraverser;
// use PhpParser\ParserFactory;
// use PhpParser\PrettyPrinter;
//
// $parser        = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);
// $traverser     = new NodeTraverser;
// $prettyPrinter = new PrettyPrinter\Standard;
//
// // add your visitor
// $traverser->addVisitor(new MyNodeVisitor);
//
// try {
//     $code = file_get_contents($fileName);
//
//     // parse
//     $stmts = $parser->parse($code);
//
//     // traverse
//     $stmts = $traverser->traverse($stmts);
//
//     // pretty print
//     $code = $prettyPrinter->prettyPrintFile($stmts);
//
//     echo $code;
// } catch (PhpParser\Error $e) {
//     echo 'Parse Error: ', $e->getMessage();
// }

return $Commander->run();

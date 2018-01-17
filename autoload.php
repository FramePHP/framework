<?php



$GetFiles = function($folder, $pattern)
{
    if(!$folder || empty($folder)) return;

    $fileList = array();

    $director = new RecursiveDirectoryIterator($folder);
    $iterator = new RecursiveIteratorIterator($director);
    $allfiles = new RegexIterator($iterator, $pattern, 0);

    foreach($allfiles as $file) {
        $path = $file->getPathname();
        if(!file_exists($file)) continue;
        require_once $fileList[] = $path;

    }
    return $fileList;
};

$sys_helpers = realpath(__DIR__.'/../../../sys/conf/');
$framework_helpers = realpath(__DIR__.'/hlp/');

$A = $GetFiles( $framework_helpers, '/\.php/msi' );
$B = $GetFiles( $sys_helpers, '/\.php/msi' );

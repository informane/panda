<?php


$classmap = [
    'controllers' => __DIR__ . '/controllers',
    'db' => __DIR__ . '/db',
    'models' => __DIR__ . '/models',
    'routers' =>__DIR__ . '/routers',
    'facades' =>__DIR__ . '/facades',
];

spl_autoload_register(function(string $classname) use ($classmap) {
    $parts = explode('\\', $classname);

    $namespace = array_shift($parts);
    $classfile = array_pop($parts) . '.php';

    if (! array_key_exists($namespace, $classmap)) {
        return;
    }

    $path = implode(DIRECTORY_SEPARATOR, $parts);
    $file = $classmap[$namespace]. DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $classfile;

    if (! file_exists($file) && ! class_exists($classname)) {
        return;
    }

    require_once $file;
});
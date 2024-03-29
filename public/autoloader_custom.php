<?php

spl_autoload_register(function($class) {
    $path = basename('framework/' . str_replace('\\', '/', $class) . '.php');
    
    if (file_exists($path)) {
        require $path;
    }
});
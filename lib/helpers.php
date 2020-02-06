<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/lib', '', __DIR__));
}

function relative_path($path) {
    return str_replace(APP_ROOT, '', $path);
}

function dd($object) {
    print_r($object) && die();
}

<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/public/lib', '', __DIR__));
    define('PUBLIC_ROOT', str_replace('/lib', '', __DIR__));
    
    require_once "db_helpers.php";
    require_once "ui_helpers.php";
    
    boot_application();
}

function redirect($url) {
    header("location: $url") && die();
}

function arrget($obj, $key, $default = null) {
    if (is_array($obj)) {
        return array_key_exists($key, $obj) ? $obj[$key] : $default;
    }
    if (is_object($obj)) {
        return isset($obj->{$key}) ? $obj->{$key} : $default;
    }
    return $default;
}

function _esc($input) {
    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding = 'UTF-8');
}

function req($key, $default = null) {
    if (isset($_GET[$key])) {
        return $_GET[$key];
    }
    if (isset($_POST[$key])) {
        return $_POST[$key];
    }
    return $default;
}

function boot_application() {
    
    if (!$handle = @fopen(APP_ROOT . '/.env', "r")) {
        die("<h1>Please setup your `.env` file</h1>");
    }
    
    while (($line = fgets($handle, 4096)) !== false) {
        if ($line = preg_replace("/\n/", '', $line)) {
            putenv($line);
        }
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
    
    DB::build();
}

function relative_path($path) {
    return str_replace(PUBLIC_ROOT, '', $path);
}

function env($key, $default = null) {
    if ($value = getenv($key)) {
        return $value;
    }
    return $default;
}

function dump($object) {
    echo "<pre>";
    print_r($object);
    echo "</pre>";
}

function dd($object) {
    echo "<pre>";
    print_r($object) && die();
}

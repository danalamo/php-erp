<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/public/lib', '', __DIR__));
    define('PUBLIC_ROOT', str_replace('/lib', '', __DIR__));
    
    boot_application();
}

function toJson($data) {
    header('content-type: text/json');
    die(json_encode($data));
}

function parsed_request_headers() {
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $name = strtolower(str_replace('_', ' ', substr($name, 5)));
            $headers[str_replace(' ', '-', ucwords($name))] = $value;
        }
    }
    return $headers;
}

function wantsJSON() {
    $headers = parsed_request_headers();
    $accept = arrget($headers, 'Accept', '');
    $contentType = arrget($headers, 'Content-Type', '');

    return (bool)(
        strpos(strtolower($contentType), 'json') !== false
        || strpos(strtolower($accept), 'json') !== false
    );
}

function redirect($url) {
    header("location: {$url}") && die();
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
    require_once "db_helpers.php";
    require_once "ui_helpers.php";
    
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

    if (env('APP_ENV') === 'prod') {
        error_reporting(0);
    }
    
    if (wantsJSON()) {
        try {
            if ($inputs = json_decode(file_get_contents('php://input'), true)){
                $_POST = $inputs;
            }
        } catch (Exception $e) {}
    }
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

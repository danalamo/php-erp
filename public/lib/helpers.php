<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/public/lib', '', __DIR__));
    define('PUBLIC_ROOT', str_replace('/lib', '', __DIR__));
    
    require_once "db_helpers.php";
    require_once "ui_helpers.php";
    
    boot_application();
}

function relative_path($path) {
    return str_replace(APP_ROOT, '', $path);
}

function dd($object) {
    print_r($object);
}

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

}

    }
}

}

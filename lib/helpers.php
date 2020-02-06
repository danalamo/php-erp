<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/lib', '', __DIR__));
}

function relative_path($path) {
    return str_replace(APP_ROOT, '', $path);
}

function dd($object) {
    print_r($object);
}

function render($callback) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>ERP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
        <script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
        <link rel="stylesheet" href="/assets/app.css">
    </head>
    <body>
        <div class="container">
            <div class="menu-links">
                <a href="/">HOME</a></li> |
                <span>
                    Employees: 
                    <a href="/employees/add.php">ADD</a> |
                    <a href="/employees/edit.php">EDIT</a> |
                    <a href="/employees/delete.php">DELETE</a>
                </span>
            </div>
            <div><?php $callback(); ?></div>
        </div>
    </body>
</html>
<?php
}

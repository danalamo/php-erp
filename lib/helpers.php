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

function render($data, $callback) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>ERP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
        <link rel="stylesheet" href="/assets/app.css">
    </head>
    <body>
        <div class="container">
            <div class="menu-links">
                <a href="/">HOME</a> |
                <span>
                    Employees: 
                    <a href="/employees/add.php">ADD</a> |
                    <a href="/employees/edit.php">EDIT</a> |
                    <a href="/employees/delete.php">DELETE</a>
                </span>
            </div>
            <div><?php $callback($data); ?></div>
        </div>
    </body>
</html>
<?php
}


function getUsers() {
    return json_decode('
      [
        {
          "id": 99829040,
          "first_name": "Lucinda",
          "last_name": "Pollich",
          "email": "Monique.Kassulke62@hotmail.com",
          "active": true
        },
        {
          "id": 77727471,
          "first_name": "Tess",
          "last_name": "Dooley",
          "email": "Mable_Johnston66@gmail.com",
          "active": true
        },
        {
          "id": 27070478,
          "first_name": "Lea",
          "last_name": "Fahey",
          "email": "Constance_Shields@yahoo.com",
          "active": false
        },
        {
          "id": 6226025,
          "first_name": "Alfred",
          "last_name": "Leannon",
          "email": "Rylee_Sawayn@hotmail.com",
          "active": true
        },
        {
          "id": 68149645,
          "first_name": "Camilla",
          "last_name": "Heaney",
          "email": "Birdie81@hotmail.com",
          "active": false
        }
      ]
    ');
}
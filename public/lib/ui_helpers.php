<?php

function render($data, $callback) {
    $title = arrget($data, 'page_title');
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>ERP <?= $title ? " - $title" : "" ?></title>
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
                <a href="/employees/add.php">ADD</a>
                <!--                    
                | <a href="/employees/edit.php">EDIT</a> 
                | <a href="/employees/delete.php">DELETE</a>
                -->
            </span>
        </div>
        <h1 class="page-title"><?= $title ?></h1>
        <div class="page-body"><?php $callback($data); ?></div>
    </div>
    </body>
    </html>
<?php
}


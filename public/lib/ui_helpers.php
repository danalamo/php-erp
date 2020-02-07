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

function userForm($data) {
?>
    <form method="POST" id="user-form">
        <div class="input-group">
            <label for="fist">First Name</label>
            <input
                id="fist"
                type="text"
                name="first_name"
                value="<?= _esc($data['user']->first_name) ?>"
            >
        </div>
        <div class="input-group">
            <label for="last">Last Name</label>
            <input
                id="last"
                type="text"
                name="last_name"
                value="<?= _esc($data['user']->last_name) ?>"
            >
        </div>
        <div class="input-group">
            <label for="location">Location</label>
            <select id="location" name="location_id">
                <option>Select a Location</option>
                <?php foreach ($data['locations'] as $loc): ?>
                    <option
                        value="<?= _esc($loc->id) ?>"
                        <?= $data['user']->location_id === $loc->id ? 'selected' : '' ?>
                    >
                        <?= _esc("$loc->line1, $loc->city $loc->state $loc->zip") ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="input-group">
            <label for="active">Active
                <input
                    id="active"
                    type="checkbox"
                    name="active"
                    <?= $data['user']->active ? 'checked' : '' ?>
                >
            </label>
            <br><br>
        </div>
        <div class="input-group">
            <input id="save" type="submit" value="<?= $data['page_title'] ?>">
        </div>
        <?php if ('debug') : ?>
            <h4>User data</h4>
            <pre><?= json_encode($data['user'], JSON_PRETTY_PRINT) ?></pre>
            <?php if (req('first_name')) : ?>
                <h4>POST data</h4>
                <pre><?= json_encode($_POST, JSON_PRETTY_PRINT) ?></pre>
            <?php endif ?>
        <?php endif ?>
    </form>
<?php
}
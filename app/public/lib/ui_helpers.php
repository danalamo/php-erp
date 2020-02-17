<?php

function _esc($input) {
    return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding = 'UTF-8');
}

function formatLocation($location) {
    return _esc($location->line1) . ', ' 
        . _esc($location->city) . ', ' 
        . _esc($location->state) . ' ' 
        . _esc($location->zip); 
}

function renderHeadPartial() {
?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script 
        type="text/javascript" 
        src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js">
    </script>
    <script 
        type="text/javascript" 
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js">
    </script>
    <script 
        type="text/javascript" 
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js">
    </script>
    <script 
        type="text/javascript" 
        src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js">
    </script>
    <link rel="stylesheet" href="/assets/app.css">
<?php
}

function renderFooter() {
?>
    <div class="center">
        All Rights Reserved &copy; ERP - <?= date('M jS, Y') ?> <br><br>
        <em>Looking for a different version?</em> <br>
        <a href="/">Php</a> &nbsp;|&nbsp;
        <a href="/jquery">jQuery</a> &nbsp;|&nbsp;
        <a href="/react">React</a> &nbsp;|&nbsp;
        <a href="/vue">Vue</a>
        <br><br>
    </div>
    <div 
        style="
            cursor:crosshair;
            font-size:12px;
        "
        class="center debug" 
        onclick="toggleDebug()">
        de 🐞ug
        <br><br>
    </div>
    <script type="text/javascript">
        var Lib = {
          toggleActiveUser: function(target) {
            var user_json = $(target).siblings('input[name=user_json]').val() 
            var user = JSON.parse(user_json)
            user.active = user.active == true ? false : true;
            $.ajax('/employees/edit.php?user_id=' + user.id, {
                method: 'POST',
                headers: {
                  'content-type': 'text/json',
                  'accept': 'text/json',
                },
                data: JSON.stringify(user)
              })
              .then(function(res) {
                console.log(res)
                window.location.reload()
              })
          } 
        }
        if (!window.sessionStorage) {
            window.sessionStorage = {}
            sessionStorage.erp_debug = 0
        }
        $(function() {
            $debugMe = $('.debug-me');
        })
        function toggleDebug() {
            sessionStorage.erp_debug = sessionStorage.erp_debug == false ? 1 : 0;
            if (erpDebug()) {
              return $debugMe.removeClass('debug-me')
            }
            return $debugMe.addClass('debug-me')
        }
        function erpDebug() {
           return sessionStorage.erp_debug == false ? false : true;
        }
    </script>
<?php
}
    
function render($data, $callback) {
    $title = arrget($data, 'page_title');
    $qPath = '';
    if ($path = arrget($data, 'path', '')) {
        $qPath = "?path={$path}"; 
    }
    if (wantsJSON()) {
        return toJson($data);
    }
?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <head>
        <title>ERP <?= $title ? " - $title" : "" ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php renderHeadPartial() ?>
    </head>
    <body>
    <div class="container">
        <div class="menu-links">
            <a href="/<?= $path ?>">HOME</a> |
            <span>
                Employees: 
                <a href="/employees/add.php<?= $qPath ?>">ADD</a>
                <!--                    
                | <a href="/employees/edit.php">EDIT</a> 
                | <a href="/employees/delete.php">DELETE</a>
                -->
            </span>
        </div>
        <div class="center">
            <?php if ($path) : ?>
            <img 
                style="width:45px;"
                alt="jQuery Logo"
                src="https://user-images.githubusercontent.com/4436664/34706800-857497bc-f555-11e7-9cb3-8811455abf76.gif">
            <?php else: ?>
            <img
                style="width:85px;"
                alt="PHP Logo"
                src="https://cdn.freebiesupply.com/logos/large/2x/php-1-logo-png-transparent.png">
            <?php endif ?>
        </div>
        <h1 class="page-title"><?= $title ?></h1>
        <div class="page-body"><?php $callback($data); ?></div>
    </div>
    <?php renderFooter() ?>
    <?php if (isset($data['errors'])) : ?>
        <script>
          window.errors = JSON.parse('<?= json_encode($data["errors"]) ?>')
          window.swal && swal.fire(
            "😧 Something's Wrong",
            window.errors.join('\n'),
            'warning'
          )
        </script>
    <?php endif ?>
    </body>
    </html>
<?php
}

function userForm($data) {
?>
    <form method="POST" action="" id="user-form">
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
                <option value="">Select a Location</option>
                <?php foreach ($data['locations'] as $loc): ?>
                    <option
                        value="<?= _esc($loc->id) ?>"
                        <?= $data['user']->location_id === $loc->id ? 'selected' : '' ?>
                    >
                        <?= formatLocation($loc) ?>
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
        <div class="debug-me">
            <h4>User data</h4>
            <pre><?= json_encode($data['user'], JSON_PRETTY_PRINT) ?></pre>
            <?php if (req('first_name')) : ?>
                <h4>POST data</h4>
                <pre><?= json_encode($_POST, JSON_PRETTY_PRINT) ?></pre>
            <?php endif ?>
        </div>
    </form>
    <script type="text/javascript">
        $(function() {
          var $form = $('#user-form');
          $form.validate({
            rules: {
              first_name: 'required',
              last_name: 'required',
              location_id: 'required',
            }
          })
          $form.on('submit', function (e) {
            if (!$form.valid()) {
              e.preventDefault();
            }
          })
        });
    </script>
<?php
}
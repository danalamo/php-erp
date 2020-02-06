<?php

require_once "lib/helpers.php";

$data = [
    'users' => getUsers(),
];

render($data, function($data) {
?>
<?php
    dd(relative_path(__FILE__));
});

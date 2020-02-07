<?php

require_once "../lib/helpers.php";

$data['user'] = (object)[
    'first_name' => '',
    'last_name' => '',
    'active' => false,
    'location_id' => null,
];

$data['page_title'] = 'Add Employee';

render($data, function($data) {
    userForm($data);
});
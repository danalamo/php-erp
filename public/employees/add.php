<?php

require_once "../lib/helpers.php";

if (count($_POST)) {
    try {
        createUser();
        redirect('/');
    } catch (Exception $e) {
        $data['error'] = $e;
    }
}

$data['user'] = (object)[
    'first_name' => '',
    'last_name' => '',
    'active' => false,
    'location_id' => null,
];

try {
    $data['locations'] = getLocations();   
} catch (Exception $e) {
    $data['exception'] = $e;
}

$data['page_title'] = 'Add Employee';

render($data, function($data) {
    userForm($data);
});
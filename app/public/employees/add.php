<?php

require_once "../lib/helpers.php";

if (count($_POST)) {
    try {
        createUser();
        redirect('/');
    } catch (Exception $e) {
        $data['errors'][] = "There was a problem creating the User";
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
    $data['errors'][] = "There was a problem loading the Locations";
}

$data['page_title'] = 'Add Employee';
$data['add'] = true;

render($data, function($data) {
    userForm($data);
});
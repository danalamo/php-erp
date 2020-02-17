<?php

require_once "../lib/helpers.php";

if (!$user_id = req('user_id')) {
    redirect('/');
}

if (!'debug') {
    dd([
        '$_REQUEST' => $_REQUEST,
        '$_POST' => $_POST,
        '$_GET' => $_GET,
        "file_get_contents('php://input')" => file_get_contents('php://input')
    ]);
}

if (count($_POST)) {
    try {
        updateUserById($user_id);
        redirect('/');
    } catch (Exception $e) {
        $data['errors'][] = "There was a problem updating the User";
    }
}

try {
    $data['user'] = getUserById($user_id);
    $data['locations'] = getLocations();
} catch (Exception $e) {
    $data['errors'][] = "There was a loading the User and Locations";
}

$data['page_title'] = 'Edit Employee';
$data['edit'] = true;

render($data, function($data) {
    userForm($data);
});
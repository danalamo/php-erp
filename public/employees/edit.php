<?php

require_once "../lib/helpers.php";

if (!$user_id = req('user_id')) {
    redirect('/');
}

if (count($_POST)) {
    try {
        updateUserById($user_id);
        redirect('/');
    } catch (Exception $e) {
        $data['error'] = $e;
        dd($e);
    }
}

try {
    $data['user'] = getUserById($user_id);
    $data['locations'] = getLocations();
} catch (Exception $e) {
    $data['exception'] = $e;
}

$data['page_title'] = 'Edit Employee';

render($data, function($data) {
    userForm($data);
});
<?php

require_once "../lib/helpers.php";

if (!$user_id = req('user_id')) {
    redirect('/');
}

try {
    deleteUserById($user_id);
} catch (Exception $e) {
    $data['error'] = $e;
    dd($e);
}

redirect('/');

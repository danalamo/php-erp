<?php

require_once "lib/helpers.php";

$data = [
    'users' => getUsers(),
];

render($data, function($data) {
?>
    <table class="stripped">
        <thead>
            <tr>
                <th>Active</th>
                <th>Employee Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data['users'] as $user): ?>
            <tr>
                <td><?= $user->active ? 'true' : 'false' ?></td>
                <td><?= "{$user->first_name} {$user->last_name}" ?></td>
                <td><?= $user->email ?></td>
                <td><?= 'Edit | Delete' ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>  
<?php
    dd(relative_path(__FILE__));
});

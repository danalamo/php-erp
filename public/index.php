<?php

require_once "lib/helpers.php";

try {
    $sth = DB::pdo()->prepare("SELECT * FROM users");
    $sth = pdo()->prepare("SELECT * FROM users");
    $sth->execute([]);
    $users = $sth->fetchAll();
} catch (Exception $e) {
    
}

$data = [
    'users' => $users,
];

render($data, function($data) {
?>
    <table class="stripped">
        <thead>
            <tr>
                <th>Active</th>
                <th>Employee Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($data['users'] as $user): ?>
            <tr>
                <td><?= $user->active ? 'true' : 'false' ?></td>
                <td><?= "{$user->first_name} {$user->last_name}" ?></td>
                <td><?= 'Edit | Delete' ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
<?php
});

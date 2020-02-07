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
$data['page_title'] = 'Employee Directory';

render($data, function($data) {
?>
    <div class="table responsive">
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
                <tr 
                    <?= $user->active ? '' : ' class="user-inactive" ' ?>
                >
                    <td><?= $user->active ? 'Yes' : 'No' ?></td>
                    <td><?= _esc("{$user->last_name}, {$user->first_name}") ?></td>
                    <td><?= _esc("$user->line1; $user->city, $user->state $user->zip") ?></td>
                    <td>
                        <a href="/employees/edit.php?user_id=<?= $user->id ?>">edit</a>
                        | <a href="/employees/delete.php?user_id=<?= $user->id ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php
});
